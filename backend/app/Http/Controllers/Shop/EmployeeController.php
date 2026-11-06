<?php

namespace App\Http\Controllers\Shop;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\EmployeeRecordMail;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopLog;
use App\Models\SystemLog;

class EmployeeController extends Controller
{
    public function indexEmployee(Request $request) {

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

            $employeeData = User::where('shop_id', $shopData->id)
                ->where('status', 'active')
                ->get()
                ->map(function ($item) {
                    return [
                        "user_id" => $item->user_id,
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone_country_code" => $item->phone_country_code,
                        "phone" => $item->phone,
                        "country" => $item->country,
                        "birthdate" => $item->birthdate,
                        "document_type" => $item->document_type,
                        "identification" => $item->identification,
                        "address" => $item->address,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($employeeData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_EMPLOYEES_NOT_FOUND',
                    'message' => 'No se encontraron empleados activos para esta tienda.'
                ], 404);
            }

            $totalEmployee = User::where('shop_id', $shopData->id)->where('status', 'active')->count();
            $firstEmployee = optional(User::orderBy('created_at')->where('shop_id', $shopData->id)->where('status', 'active')->first())->created_at?->format('Y-m-d');
            $lastEmployee  = optional(User::orderByDesc('created_at')->where('shop_id', $shopData->id)->where('status', 'active')->first())->created_at?->format('Y-m-d');

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_EMPLOYEES_RETRIEVED',
                'message' => 'Empleados activos recuperados correctamente.',
                'data' => [
                    "total_employees" => $totalEmployee,
                    "first_employee" => $firstEmployee,
                    "last_employee" => $lastEmployee,
                    "employees" => $employeeData
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/employee?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }  
    }

    public function indexSearchEmployee(Request $request) {

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

            $employeeData = User::where('shop_id', $shopData->id)
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
                        "user_id" => $item->user_id,
                        "name" => $item->name,
                        "email" => $item->email,
                        "phone_country_code" => $item->phone_country_code,
                        "phone" => $item->phone,
                        "country" => $item->country,
                        "birthdate" => $item->birthdate,
                        "document_type" => $item->document_type,
                        "identification" => $item->identification,
                        "address" => $item->address,
                        "status" => $item->status,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                    ];
                });

            if ($employeeData->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_EMPLOYEE_NOT_FOUND',
                    'message' => 'No se encontró un empleado activo.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_EMPLOYEE_FOUND',
                'message' => 'Empleado encontrado correctamente.',
                'data' => $employeeData
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/employee/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function storeEmployee(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phoneCountryCode = $request->input('phone_country_code');
            $phoneNumber = $request->input('phone');
            $country = $request->input('country');
            $birthdate = $request->input('birthdate');
            $documentType = $request->input('document_type');
            $identification = $request->input('identification');
            $address = $request->input('address');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($name)) || empty(trim($email)) || empty(trim($phoneCountryCode)) || empty(trim($phoneNumber)) || empty(trim($country)) || empty(trim($birthdate)) || empty(trim($documentType)) || empty(trim($identification)) || empty(trim($address))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($name))) $missing[] = 'name';
                if (empty(trim($email))) $missing[] = 'email';
                if (empty(trim($phoneCountryCode))) $missing[] = 'phoneCountryCode';
                if (empty(trim($phoneNumber))) $missing[] = 'phoneNumber';
                if (empty(trim($country))) $missing[] = 'country';
                if (empty(trim($birthdate))) $missing[] = 'birthdate';
                if (empty(trim($documentType))) $missing[] = 'documentType';
                if (empty(trim($identification))) $missing[] = 'identification';
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

            if (User::where('shop_id', $shopData->id)->where('identification', $identification)->where('status', 'active')->exists()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_EMPLOYEE_ALREADY_EXISTS',
                    'message' => 'Ya existe un empleado activo con este documento en la tienda.'
                ], 409);
            }

            do {
                $userId = uniqid();
                $logId = uniqid();
            } while (User::where('user_id', $userId)->exists() || ShopLog::where('log_id', $logId)->exists());

            User::create([
                'user_id' => $userId,
                'shop_id' => $shopData->id,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($identification),
                'phone_country_code' => $phoneCountryCode,
                'phone' => $phoneNumber,
                'country' => $country,
                'birthdate' => $birthdate,
                'document_type' => $documentType,
                'identification' => $identification,
                'address' => $address,
            ]);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Nuevo empleado/a: $identification"
            ]);

            try {
                Mail::to($email)->send(new EmployeeRecordMail($shopData->name, $name, $identification));
                $statusMail = true;
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
            
            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_EMPLOYEE_CREATED',
                'message' => 'Empleado registrado correctamente.',
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/employee?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateEmployee(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');
            $employeeId = $request->query('employee_id');

            $name = $request->input('name');
            $email = $request->input('email');
            $phoneCountryCode = $request->input('phone_country_code');
            $phoneNumber = $request->input('phone');
            $country = $request->input('country');
            $birthdate = $request->input('birthdate');
            $address = $request->input('address');
            //$apiToken = $request->bearerToken();

            if (empty(trim($shopKey)) || empty(trim($userId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($employeeId))) $missing[] = 'employee_id';
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

            $updates = [];
            if ($name !== null) $updates['name'] = $name; 
            if ($email !== null) $updates['email'] = $email;
            if ($phoneNumber !== null) $updates['phone'] = $phoneNumber;
            if ($country !== null) $updates['country'] = $country;
            if ($birthdate !== null) $updates['birthdate'] = $birthdate;
            if ($address !== null) $updates['address'] = $address;

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            $employeeData = User::where('user_id', $employeeId)->first();

            User::where('user_id', $employeeId)->update($updates);

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Empleado actualizado: $employeeData->identification"
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_EMPLOYEE_UPDATED',
                'message' => 'Empleado actualizado correctamente.'
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/employee?shop_key={$shopKey}&user_id={$userId}&employee_id={$employeeId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function deleteEmployee(Request $request) {

        try {
            $shopKey = $request->query('shop_key');
            $employeeId = $request->query('employee_id');
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

            if (User::where('user_id', $employeeId)->where('status', 'inactive')->exists()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_EMPLOYEE_INACTIVE',
                    'message' => 'El empleado no está activo el registro.'
                ], 404);
            }

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            User::where('user_id', $employeeId)->update(['status' => 'inactive']);
            
            $employeeData = User::where('user_id', $employeeId)->first();

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id, 
                'details' => "Empleado eliminado: $employeeData->identification."
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_EMPLOYEE_DELETED',
                'message' => 'Empleado eliminado correctamente.'
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/employee?shop_key={$shopKey}&employee_id={$employeeId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }
}