<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ShopCategory;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopLog;
use App\Models\SystemLog;

class CategoryController extends Controller
{   
    public function indexCategory(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->select('id')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada."
                ], 404);
            }

            // if ($shopData->api_token !== $apiToken) {
            //     return response()->json([
            //         'status' => false,
            //         'code' => 'ERR_UNAUTHORIZED',
            //         'message' => 'Acceso no autorizado. Token inválido.'
            //     ], 401);
            // }

            $categoryData = ShopCategory::where('shop_id', $shopData->id)
                ->where('status', true)
                ->get()
                ->map(function ($item) {
                    return [
                        "category_id" => $item->category_id,
                        "user" => User::where('id', $item->user_id)->value('name'),
                        "name" => $item->name,
                        "description" => $item->description,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($categoryData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CATEGORIES_NOT_FOUND',
                    'message' => 'No se encontraron categorias activas para esta tienda.'
                ], 404);
            }

            $firstCategory = optional(ShopCategory::orderBy('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');
            $lastCategory  = optional(ShopCategory::orderByDesc('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');
            $totalCategory = ShopCategory::where('shop_id', $shopData->id)->where('status', true)->count();
            
            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CATEGORIES_RETRIEVED',
                'message' => 'Categorias obtenidas exitosamente.',
                'data' => [
                    "total_category" => $totalCategory,
                    "first_category" => $firstCategory,
                    "last_category" => $lastCategory,
                    "categories" => $categoryData
                    ]
            ], 200);

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'GET',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/categories?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function indexSearchCategory(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $searchTerm = $request->query('search_term');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($searchTerm)) ) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($searchTerm))) $missing[] = 'search_term';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada."
                ], 404);
            }

            // if ($shopData->api_token !== $apiToken) {
            //     return response()->json([
            //         'status' => false,
            //         'code' => 'ERR_UNAUTHORIZED',
            //         'message' => 'Acceso no autorizado. Token inválido.'
            //     ], 401);
            // }

            $categoryData = ShopCategory::where('shop_id', $shopData->id)
                ->where('status', true)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                })
                ->get()
                ->map(function ($item) {
                    return [
                        "category_id" => $item->category_id,
                        "user"        => User::where('id', $item->user_id)->value('name'),
                        "name"        => $item->name,
                        "description"     => $item->description,
                        "status"      => $item->status,
                        "created_at"  => $item->created_at,
                        "updated_at"  => $item->updated_at,
                    ];
                });

            if ($categoryData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CATEGORY_NOT_FOUND',
                    'message' => 'No se encontro la categoria especificada para esta tienda.'
                ], 404);
            }
            
            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CATEGORY_RETRIEVED',
                'message' => 'Categorias obtenidas exitosamente.',
                'data' => $categoryData
            ], 200);

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'GET',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/categories/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function storeCategory(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');

            $name = $request->input('name');
            $description = $request->input('description');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($name)) ) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($name))) $missing[] = 'name';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada."
                ], 404);
            }

            $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

            if (empty($userData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_USER_NOT_FOUND',
                    'message' => 'El usuario especificado no se encuentra registrado.'
                ], 404);
            };

            if (ShopCategory::where('shop_id', $shopData->id)->where('name', $name)->where('status', 1)->exists()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CATEGORY_ALREADY_EXISTS',
                    'message' => 'La categoria ya se encuentra registrada.'
                ], 409);
            }   

            do {
                $categoryId = uniqid();
                $logId = uniqid();
            } while (ShopCategory::where('category_id', $categoryId)->exists() || ShopLog::where('log_id', $logId)->exists());
            
            ShopCategory::create([
                'category_id' => $categoryId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'name' => $name,
                'description' => $description,
            ]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Nueva categoria: $name"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CATEGORY_CREATED',
                'message' => "Categoria registrada exitosamente.",
            ], 201);

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'POST',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/categories?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateCategory(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $categoryId = $request->query('category_id');
            $userId = $request->query('user_id');
            $name = $request->input('name');
            $description = $request->input('description');
            //$apiToken = $request->bearerToken();
 
            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($categoryId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($categoryId))) $missing[] = 'category_id';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada."
                ], 404);
            }

            $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

            if (empty($userData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_USER_NOT_FOUND',
                    'message' => 'El usuario especificado no se encuentra registrado.'
                ], 404);
            };

            $categoryData = ShopCategory::where('category_id', $categoryId)->first();
            
            if (empty($categoryData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CATEGORY_NOT_FOUND',
                    'message' => 'La categoria especificada no se encuentra registrada.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            $updates = [];
            if ($name !== null) $updates['name'] = $name;
            if ($description !== null) $updates['description'] = $description;

            ShopCategory::where('id', $categoryData->id)->update($updates);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Categoria actualizada: $categoryData->name."
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CATEGORY_UPDATED',
                'message' => "Categoria actualizada exitosamente.",
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/categories?shop_key={$shopKey}&category_id={$categoryId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function deleteCategory(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $categoryId = $request->query('category_id');
            $userId = $request->query('user_id');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($categoryId))) $missing[] = 'category_id';
                //if (empty(trim($apiToken))) $missing[] = 'Bearer Token';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada."
                ], 404);
            }

            $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

            if (empty($userData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_USER_NOT_FOUND',
                    'message' => 'El usuario especificado no se encuentra registrado.'
                ], 404);
            };

            $categoryData = ShopCategory::where('category_id', $categoryId)->first();
            
            if (empty($categoryData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CATEGORY_NOT_FOUND',
                    'message' => 'La categoria especificada no se encuentra registrada.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());


            ShopCategory::where('category_id', $categoryId)->update(['status' => 0,]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Categoria eliminada: $categoryData->name"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CATEGORY_DELETED',
                'message' => "Categoria eliminada correctamente.",
            ], 200);

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'DELETE',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/categories?shop_key={$shopKey}&category_id={$categoryId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }
}