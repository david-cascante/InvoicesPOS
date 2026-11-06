<?php

namespace App\Http\Controllers\Shop;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopClient;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopLog;
use App\Models\SystemLog;

class ClientController extends Controller
{
    public function indexClient(Request $request) {

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

            $clientData = ShopClient::where('shop_id', $shopData->id)
                ->where('status', true)
                ->get()
                ->map(function ($item) {
                    return [
                        "client_id" => $item->client_id,
                        "user" => User::where('id', $item->user_id)->value('name'),
                        "document_type" => $item->document_type,
                        "identification" => $item->identification,
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone" => $item->phone,
                        "address" => $item->address,
                        "credits" => $item->credits,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($clientData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CLIENTS_NOT_FOUND',
                    'message' => 'No se encontraron clientes activos para esta tienda.'
                ], 404);
            }

            $totalClient = ShopClient::where('shop_id', $shopData->id)->where('status', true)->count();
            $firstClient = optional(ShopClient::orderBy('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');
            $lastClient  = optional(ShopClient::orderByDesc('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CLIENTS_RETRIEVED',
                'message' => 'Clientes recuperados correctamente.',
                'data' => [
                    "total_clients" => $totalClient,
                    "first_client" => $firstClient,
                    "last_client" => $lastClient,
                    "clients" => $clientData
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/client?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }  
    }

    public function indexSearchClient(Request $request) {
        
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

            $clientData = ShopClient::where('shop_id', $shopData->id)
                ->where('status', true)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('identification', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
                })
                ->get()
                ->map(function ($item) {
                    return [
                        "client_id" => $item->client_id,
                        "user" => User::where('id', $item->user_id)->value('name'),
                        "document_type" => $item->document_type,
                        "identification" => $item->identification,
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone" => $item->phone,
                        "address" => $item->address,
                        "credits" => $item->credits,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($clientData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CLIENT_NOT_FOUND',
                    'message' => 'No se encontro el cliente especificado para esta tienda.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CLIENTS_RETRIEVED',
                'message' => 'Cliente recuperado correctamente.',
                'data' => $clientData
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/clients/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function storeClient(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');

            $name = $request->input('name');
            $documentType = $request->input('document_type');
            $identification = $request->input('identification');
            $email = $request->input('email');
            $phoneNumber = $request->input('phone');
            $address = $request->input('address');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($name)) || empty(trim($documentType)) || empty(trim($identification)) || empty(trim($email)) || empty(trim($phoneNumber)) || empty(trim($address))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($documentType))) $missing[] = 'document_type';
                if (empty(trim($identification))) $missing[] = 'identification';
                if (empty(trim($email))) $missing[] = 'email';
                if (empty(trim($phoneNumber))) $missing[] = 'phone';
                if (empty(trim($address))) $missing[] = 'address';
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

            if (ShopClient::where('shop_id', $shopData->id)->where('identification', $identification)->where('status', 1)->exists()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CLIENT_ALREADY_EXISTS',
                    'message' => 'El cliente ya se encuentra registrada.'
                ], 409);
            }

            do {
                $clientId = uniqid();
                $logId = uniqid();
            } while (ShopClient::where('client_id', $clientId)->exists() || ShopLog::where('log_id', $logId)->exists());

            ShopClient::where('shop_id', $shopData->id)->create([
                'client_id' => $clientId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'document_type' => $documentType,
                'identification' => $identification,
                'name' => $name,
                'email' => $email,
                'phone' => $phoneNumber,
                'address' => $address,
            ]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Cliente nuevo: $identification"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CLIENT_CREATED',
                'message' => "Cliente registrado correctamente.",
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/clients?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateClient(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');
            $clientId = $request->query('client_id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phoneNumber = $request->input('phone');
            $address = $request->input('address');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($clientId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($clientId))) $missing[] = 'client_id';
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

            $clientData = ShopClient::where('client_id', $clientId)->where('status', 1)->first();

            if (empty($clientData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CLIENT_NOT_FOUND',
                    'message' => 'El cliente especificado no se encuentra registrado.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            $updates = [];
            if ($name !== null) $updates['name'] = $name; 
            if ($email !== null) $updates['email'] = $email;
            if ($phoneNumber !== null) $updates['phone'] = $phoneNumber;
            if ($address !== null) $updates['address'] = $address;

            ShopClient::where('client_id', $clientId)->update($updates);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Cliente actualizado: $clientData->identification"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CLIENT_UPDATED',
                'message' => "Cliente actualizado correctamente.",
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/clients?shop_key={$shopKey}&user_id={$userId}&client_id={$clientId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function deleteClient(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $clientId = $request->query('client_id');
            $userId = $request->query('user_id');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
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

            $clientData = ShopClient::where('client_id', $clientId)->where('status', 1)->first();

            if (empty($clientData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_CLIENT_NOT_FOUND',
                    'message' => 'El cliente especificado no se encuentra registrado.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            ShopClient::where('client_id', $clientId)->update(['status' => 0]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Cliente eliminado: $clientData->identification"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_CLIENT_UPDATED',
                'message' => "Cliente eliminado correctamente.",
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/clients?shop_key={$shopKey}&client_id={$clientId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }
}