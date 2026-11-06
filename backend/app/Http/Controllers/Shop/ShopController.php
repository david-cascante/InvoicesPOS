<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\License;
use App\Models\Shop;
use App\Models\ShopLog;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;

class ShopController extends Controller
{
    public function indexShop(Request $request) : JsonResponse {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_MISSING_DATA',
                'message' => 'Todos los parametros y datos deben de estar completos.'
            ], 400);
        }

        $userData = User::where('user_id', $userId)->where('status', 'active')->select('id', 'name')->first();

        if ($userData == null) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_USER_NOT_FOUND',
                'message' => 'El usuario especificado no se encuentra registrado.'
            ], 404);
        }

        $shopData = Shop::where('user_id', $userData->id)->select('shop_id', 'shop_key', 'name', 'type', 'currency', 'credits', 'status', 'created_at', 'updated_at')->get();

        return response()->json([
            'status' => true,
            'code' => 'SUCCESS_SHOPS_RETRIEVED',
            'message' => 'Tiendas activas recuperados correctamente.',
            'userName' => $userData->name,
            'shopData' => $shopData,
        ], 200);
    }

    public function indexLog(Request $request) {
        $shopKey = $request->query('shop_key');

        if (!$shopKey) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_MISSING_DATA',
                'message' => 'Todos los parametros y datos deben de estar completos.'
            ], 400);
        }

        $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

        if (!$shopData) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_SHOP_NOT_FOUND',
                'message' => 'La tienda especificado no se encuentra registrado.'
            ], 404);
        }

        $shopLog = ShopLog::where('shop_id', $shopData->id)->where('status', true)->get()
                    ->map(function ($items) {
                        return [
                            "log_id" => $items->log_id,
                            "user" => User::where('id', $items->user_id)->value('name'),
                            "details" => $items->details,
                            "date" => $items->created_at
                        ];
                    });;

        return response()->json([
            'status' => true,
            'code' => 'SUCCESS_SHOPS_RETRIEVED',
            'message' => 'Registro activos recuperados correctamente.',
            'Data' => $shopLog,
        ], 200);
    }

    public function storeShop(Request $request) : JsonResponse {
        $userId = $request->query('user_id');

        $name = $request->input('name');
        $type = $request->input('type');
        
        if (!$userId ||!$name ||!$type) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_MISSING_DATA',
                'message' => 'Todos los parametros y datos deben de estar completos.'
            ], 400);
        }

        $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

        if ($userData == null) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_USER_NOT_FOUND',
                'message' => 'El usuario especificado no se encuentra registrado.'
            ], 404);
        };

        $license = License::where('user_id', $userData->id)->where('status', 'pending')->first();

        if ($license == null) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_USER_NOT_HAVE_LICENSE',
                'message' => 'No existe una clave de licencia disponible.'
            ], 404);
        }

        do {
            $shopKey = Str::uuid();
            $shopId = uniqid();
            $logId = uniqid();
        } while (Shop::where('shop_id', $shopId)->orWhere('shop_key', $shopKey)->exists() || UserLog::where('log_id', $logId)->exists());
        
        
        $ip = $request->ip();
        if ($ip === "127.0.0.1") {
            $ip = "8.8.8.8"; // Para pruebas locales
        }

        License::where('id', $license->id)->update(['status' => 'activated']);
        
        Shop::create([
            'shop_id' => $shopId,
            'user_id' => $userData->id,
            'license_id' => $license->id,
            'shop_key' => $shopKey,
            'api_token' => Str::random(60),
            'name' => $name,
            'type' => $type,
            'ip_address' => $ip,
        ]);
        
        UserLog::create([
            'log_id' => $logId,
            'user_id' => $userData->id,
            'details' => "Se creo correctamente la tienda $name"
        ]);

        return response()->json([
            'status' => true,
            'code' => 'SUCCESS_SHOP_CREATED',
            'message' => "Tienda registrada correctamente y licencia activada correctamente.",
        ], 201);
        
    }

    public function updateShop(Request $request, $shop_key) : JsonResponse {

        try {
            $shopKey = $shop_key;
            
            $userId = $request->input('user_id');
            $name = $request->input('name');
            $type = $request->input('type');
            $currency = $request->input('currency');
            $credits = $request->input('credits');

            if (empty(trim($shopKey)) || empty(trim($userId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'error_code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'error_code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada. Clave: {$shopKey}"
                ], 404);
            }

            $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

            if (empty($userData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_USER_NOT_FOUND',
                    'message' => 'El usuario especificado no se encuentra registrado.'
                ], 404);
            }

            $updates = [];

            if ($name !== null) $updates['name'] = $name;
            if ($type !== null) $updates['type'] = $type;
            if ($currency !== null) $updates['currency'] = $currency;
            if ($credits !== null) $updates['credits'] = $credits;

            Shop::where('id', $shopData->id)->update($updates);

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'details' => "Tienda actualizada. ID: $shopData->shop_id",
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SHOP_UPDATED',
                'message' => 'Tienda actualizada con éxito.'
            ], 200);
            
        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'PUT',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/shop?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
        
    }
}
