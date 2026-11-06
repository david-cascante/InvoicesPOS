<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopSupplier;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopLog;
use App\Mail\SupplierRecordMail;
use Illuminate\Support\Facades\Mail;
use App\Models\SystemLog;

class SupplierController extends Controller
{
    public function indexSupplier(Request $request) {

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

            $supplierData = ShopSupplier::where('shop_id', $shopData->id)
                ->where('status', true)
                ->get()
                ->map(function ($item) {
                    return [
                        "supplier_id" => $item->supplier_id,
                        "user" => User::where('id', $item->user_id)->value('name'),
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone" => $item->phone,
                        "address" => $item->address,
                        "tax_id" => $item->tax_id,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });
            
            if ($supplierData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SUPPLIER_NOT_FOUND',
                    'message' => 'No se encontraron proveedores activos para esta tienda.'
                ], 404);
            }

            $totalSuppliers = ShopSupplier::where('shop_id', $shopData->id)->where('status', true)->count();
            $firstSupplier = optional(ShopSupplier::orderBy('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');
            $lastSupplier  = optional(ShopSupplier::orderByDesc('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SUPPLIER_RETRIEVED',
                'message' => 'Proveedores activos recuperados correctamente.',
                'data' => [
                    "total_suppliers" => $totalSuppliers,
                    "first_supplier" => $firstSupplier,
                    "last_supplier" => $lastSupplier,
                    "suppliers" => $supplierData
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/supplier?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function indexSearchSupplier(Request $request) {

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

            $supplierData = ShopSupplier::where('shop_id', $shopData->id)
                ->where('status', true)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('tax_id', 'LIKE', "%{$searchTerm}%");
                })
                ->get()
                ->map(function ($item) {
                    return [
                        "supplier_id" => $item->supplier_id,
                        "user" => User::where('id', $item->user_id)->value('name'),
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone" => $item->phone,
                        "address" => $item->address,
                        "tax_id" => $item->tax_id,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($supplierData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SUPPLIER_NOT_FOUND',
                    'message' => 'No se encontró un proveedor activo con el nombre proporcionado.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SUPPLIER_FOUND',
                'message' => 'Proveedor encontrado correctamente.',
                'data' => $supplierData, 
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/supplier/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function storeSupplier(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phoneNumber = $request->input('phone');
            $address = $request->input('address');
            $description = $request->input('description');
            $taxId = $request->input('tax_id');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($name)) || empty(trim($email)) || empty(trim($phoneNumber)) || empty(trim($address)) || empty(trim($taxId)) ) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($name))) $missing[] = 'name';
                if (empty(trim($email))) $missing[] = 'email';
                if (empty(trim($phoneNumber))) $missing[] = 'phone_number';
                if (empty(trim($address))) $missing[] = 'address';
                if (empty(trim($taxId))) $missing[] = 'tax_id';
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

            $existsByName = ShopSupplier::where('shop_id', $shopData->id)
                ->where('name', $name)
                ->where('status', 1)
                ->exists();

            $existsByTaxId = ShopSupplier::where('shop_id', $shopData->id)
                ->where('tax_id', $taxId)
                ->where('status', 1)
                ->exists();

            if ($existsByName || $existsByTaxId) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SUPPLIER_ALREADY_EXISTS',
                    'message' => 'Ya existe un provedor igual, activo en la tienda.'
                ], 409);
            }

            do {
                $supplierId = uniqid();
                $logId = uniqid();
            } while (ShopSupplier::where('supplier_id', $supplierId)->exists() || ShopLog::where('log_id', $logId)->exists());
            
            ShopSupplier::create([
                'supplier_id' => $supplierId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'name' => $name,
                'email' => $email,
                'phone' => $phoneNumber,
                'address' => $address,
                'details' => $description,
                'tax_id' => $taxId,
            ]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Nuevo provedor: $name"
            ]);

            if ($userData->sending_emails == true) {
                try {
                    Mail::to($userData->email)->send(new SupplierRecordMail($shopData->name, $name, $userData->name, now()));

                    $statusMail = true;
                    $message = 'Provedor registrado y correo de notificación enviado correctamente.';
                } catch (\Exception $e) {
                    $statusMail = false;
                }

                if (!$statusMail) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_EMAIL_SEND_FAILED',
                        'message' => 'El email no se logro enviar correctamente.'
                    ], 500);
                }
            } else {
                $message = 'Provedor registrado correctamente.';
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SUPPLIER_CREATED',
                'message' => $message,
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/supplier?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateSupplier(Request $request) {
        
        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');
            $supplierId = $request->query('supplier_id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phoneNumber = $request->input('phone');
            $address = $request->input('address');
            $details = $request->input('details');
            $taxId = $request->input('tax_id');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($supplierId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($supplierId))) $missing[] = 'supplier_id';
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
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            $updates = [];
            if ($name !== null) $updates['name'] = $name;
            if ($email !== null) $updates['email'] = $email;
            if ($phoneNumber !== null) $updates['phone'] = $phoneNumber;
            if ($address !== null) $updates['address'] = $address;
            if ($taxId !== null) $updates['tax_id'] = $taxId;
            
            ShopSupplier::where('supplier_id', $supplierId)->update($updates);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Proveedor actualizado: $shopData->name"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SUPPLIER_UPDATED',
                'message' => "Proveedor actualizado correctamente.",
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/supplier?shop_key={$shopKey}&user_id={$userId}&supplier_id={$supplierId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function deleteSupplier(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $supplierId = $request->query('supplier_id');
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

            $supplierData = ShopSupplier::where('supplier_id', $supplierId)->where('status', 1)->first();

            if (empty($supplierData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SUPPLIER_NOT_FOUND',
                    'message' => 'El proveedor especificado no se encuentra registrado.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            ShopSupplier::where('supplier_id', $supplierId)->update(['status' => 0]);

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Proveedor eliminado: $supplierData->name"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_SUPPLIER_DELETED',
                'message' => 'Proveedor eliminado correctamente.'
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/supplier?shop_key={$shopKey}&supplier_id={$supplierId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }
}