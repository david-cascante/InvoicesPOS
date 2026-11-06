<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopLog;
use App\Models\ShopProduct;
use App\Models\ShopSupplier;
use App\Models\ShopCategory;
use App\Models\ShopInventory;
use App\Models\SystemLog;

class ProductController extends Controller
{
    public function indexProduct(Request $request)
    {
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

            $products = ShopProduct::where('shop_id', $shopData->id)
                            ->where('status', true)
                            ->get()
                            ->map(function ($product) {
                                return [
                                    "product_id" => $product->product_id,
                                    "user" => User::where('id', $product->user_id)->value('name'),
                                    "supplier" => ShopSupplier::where('id', $product->supplier_id)->value('name'),
                                    "name" => $product->name,
                                    "description" => $product->description,
                                    "purchase_price" => $product->purchase_price,
                                    "sale_price" => $product->sale_price,
                                    "continued" => $product->continued,
                                    'bar_code' => $product->bar_code,
                                    "reference" => $product->reference,
                                    "status" => $product->status,
                                    "created_at" => $product->created_at,
                                    "updated_at" => $product->updated_at,
                                ];
                            });

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCTS_NOT_FOUND',
                    'message' => 'No hay productos registrados en esta tienda.'
                ], 404); 
            }

            $totalProducts = ShopProduct::where('shop_id', $shopData->id)->where('status', true)->count();
            $firstProduct = optional(ShopProduct::orderBy('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');
            $lastProduct  = optional(ShopProduct::orderByDesc('created_at')->where('shop_id', $shopData->id)->where('status', true)->first())->created_at?->format('Y-m-d');

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_PRODUCTS_RETRIEVED',
                'message' => 'Productos obtenidos exitosamente.',
                'data' => [
                    "total_products" => $totalProducts,
                    "first_product" => $firstProduct,
                    "last_product" => $lastProduct,
                    "products" => $products
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/product?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function indexSearchProduct(Request $request)
    {
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

            $products = ShopProduct::where('shop_id', $shopData->id)
                ->where('status', true)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('bar_code', 'LIKE', "%{$searchTerm}%");
                })
                ->get()
                ->map(function ($product) {
                    return [
                        "product_id" => $product->product_id,
                        "user" => User::where('id', $product->user_id)->value('name'),
                        "product" => Shopproduct::where('id', $product->product_id)->value('name'),
                        "supplier" => ShopSupplier::where('id', $product->supplier_id)->value('name'),
                        "name" => $product->name,
                        "description" => $product->description,
                        "purchase_price" => $product->purchase_price,
                        "sale_price" => $product->sale_price,
                        "bar_code" => $product->bar_code,
                        "continued" => $product->continued,
                        "reference" => $product->reference,
                        "status" => $product->status,
                        "created_at" => $product->created_at,
                        "updated_at" => $product->updated_at,
                    ];
                });

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_NO_PRODUCTS_FOUND',
                    'message' => 'No se encontraron productos que coincidan con el termino de busqueda.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_PRODUCTS_RETRIEVED',
                'message' => 'Productos obtenidos exitosamente.',
                'data' => $products
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/product/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }  

    public function storeProduct(Request $request)
    {
        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');
            $supplierId = $request->input('supplier_id');
            $categoryId = $request->input('category_id');
            $name = $request->input('name');
            $description = $request->input('description');
            $purchasePrice = $request->input('purchase_price');
            $salePrice = $request->input('sale_price');
            $units = $request->input('units');
            $unitMeasurement = $request->input('unit_measurement');
            $barCode = $request->input('bar_code');
            $stockAlert = $request->input('stock_alert');
            $tax = $request->input('tax');
            $reference = $request->input('reference');
            //$apiToken = $request->bearerToken();

            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($supplierId)) || empty(trim($categoryId)) || empty(trim($name)) || empty(trim($purchasePrice)) || empty(trim($salePrice)) || empty(trim($units)) || empty(trim($unitMeasurement)) || empty(trim($barCode)) || empty(trim($stockAlert)) || empty(trim($reference))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($categoryId))) $missing[] = 'category_id';
                if (empty(trim($name))) $missing[] = 'name';
                if (empty(trim($purchasePrice))) $missing[] = 'purchase_price';
                if (empty(trim($salePrice))) $missing[] = 'sale_price';
                if (empty(trim($units))) $missing[] = 'units';
                if (empty(trim($unitMeasurement))) $missing[] = 'unit_measurement';
                if (empty(trim($barCode))) $missing[] = 'bar_code';
                if (empty(trim($stockAlert))) $missing[] = 'stock_alert';
                if (empty(trim($tax))) $missing[] = 'tax';
                if (empty(trim($reference))) $missing[] = 'reference';
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

            if (ShopProduct::where('shop_id', $shopData->id)->where('status', true)->where('bar_code', $barCode)->exists()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCT_ALREADY_EXISTS',
                    'message' => 'El producto ya se encuentra registrado.'
                ], 409);
            }

            if (!is_numeric($purchasePrice) || !is_numeric($salePrice) || !is_numeric($units)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_NUMBER',
                    'message' => 'Los valores de precio de compra, precio de venta y unidades deben ser numeros validos.'
                ], 400);
            }
            
            if ($purchasePrice < 0 || $salePrice < 0) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_PRICE',
                    'message' => 'Los precios no pueden ser negativos.'
                ], 400);
            }

            if (!in_array($unitMeasurement, ['unit', 'piece', 'box', 'pack', 'liter', 'ml', 'gallon', 'kg', 'g', 'pound'])) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_UNIT_MEASUREMENT',
                    'message' => 'El tipo de unidad de medida proporcionado no es valido.'
                ], 400);
            }

            do {
                $productId = uniqid();
            } while (ShopProduct::where('product_id', $productId)->exists());

            $newProduct = ShopProduct::create([
                'product_id' => $productId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'product_id' => $productId,
                'supplier_id' => ShopSupplier::where('supplier_id', $supplierId)->value('id'),
                'category_id' => ShopCategory::where('category_id', $categoryId)->value('id'),
                'name' => $name,
                'description' => $description,
                'purchase_price' => $purchasePrice,
                'sale_price' => $salePrice,
                'units' => $units,
                'unit_measurement' => $unitMeasurement,
                'bar_code' => $barCode,
                'stock_alert' => $stockAlert,
                'tax' => $tax,
                'reference' => $reference
            ]);

            if ($newProduct) {
                // Registrar en el inventario
                do {
                    $inventoryId = uniqid();
                } while (ShopInventory::where('inventory_id', $inventoryId)->exists());

                ShopInventory::create([
                    'inventory_id' => $inventoryId,
                    'user_id' => $userData->id,
                    'product_id' => $newProduct->id,
                    'shop_id' => $shopData->id,
                    'quantity' => $units,
                    'movement_type' => 'entry',
                    'notes' => 'Initial stock entry',
                    'purchase_price' => $purchasePrice,
                    'sale_price' => $salePrice,
                    'reference' => $reference,
                    'status' => true,
                ]);

                // Registrar log
                do {
                    $logId = uniqid();
                } while (ShopLog::where('log_id', $logId)->exists());

                ShopLog::create([
                    'log_id' => $logId,
                    'user_id' => $userData->id,
                    'shop_id' => $shopData->id,
                    'details' => "Nuevo producto. Codigo numerico: {$barCode}",
                ]);

                return response()->json([
                    'status' => true,
                    'code' => 'SUCCESS_PRODUCT_CREATED',
                    'message' => 'Producto creado exitosamente.',
                ], 201);

            } else {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCT_CREATION_FAILED',
                    'message' => 'No se pudo crear el producto, intente nuevamente.'
                ], 500);
            }

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'POST',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/product?shop_key={$shopKey}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $userId = $request->query('user_id');
            $shopKey = $request->query('shop_key');
            $productId = $request->query('product_id');
            $status = $request->query('status');

            $productId = $request->input('product_id');
            $supplierId = $request->input('supplier_id');
            $name = $request->input('name');
            $description = $request->input('description');
            $purchasePrice = $request->input('purchase_price');
            $salePrice = $request->input('sale_price');
            $units = $request->input('units');
            $unitMeasurement = $request->input('unit_measurement');
            $barCode = $request->input('bar_code');
            $stockAlert = $request->input('stock_alert');
            $tax = $request->input('tax');
            $reference = $request->input('reference');

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

            $product = ShopProduct::where('product_id', $productId)->where('status', true)->first();

            if (empty($product)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCT_NOT_FOUND',
                    'message' => 'El producto proporcionado no existe en esta tienda.'
                ], 404);
            }

            $updates = [];
            if ($productId !== null) $updates['product_id'] = $productId;
            if ($supplierId !== null) $updates['supplier_id'] = $supplierId;
            if ($name !== null) $updates['name'] = $name;
            if ($description !== null) $updates['description'] = $description; 
            if ($purchasePrice !== null) {
                if (!is_numeric($purchasePrice) || $purchasePrice < 0) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_INVALID_PRICE',
                        'message' => 'El precio de compra debe ser un numero valido y no puede ser negativo.'
                    ], 400);
                }
                $updates['purchase_price'] = $purchasePrice;
            }
            if ($salePrice !== null) {
                if (!is_numeric($salePrice) || $salePrice < 0) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_INVALID_PRICE',
                        'message' => 'El precio de venta debe ser un numero valido y no puede ser negativo.'
                    ], 400);
                }

                $updates['sale_price'] = $salePrice;
            }
            if ($units !== null) {
                if (!is_numeric($units)) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_INVALID_NUMBER',
                        'message' => 'El valor de unidades debe ser un numero valido.'
                    ], 400);
                }
                $updates['units'] = $units;
            }
            if ($unitMeasurement !== null) {
                if (!in_array($unitMeasurement, ['unit', 'piece', 'box', 'pack', 'liter', 'ml', 'gallon', 'kg', 'g', 'pound'])) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_INVALID_UNIT_MEASUREMENT',
                        'message' => 'El tipo de unidad de medida proporcionado no es valido.'
                    ], 400);
                }

                $updates['unit_measurement'] = $unitMeasurement;
            }

            if ($status !== null) $updates['continued'] = $status;
            if ($barCode !== null) $updates['bar_code'] = $barCode;
            if ($stockAlert !== null) $updates['stock_alert'] = $stockAlert;
            if ($reference !== null) $updates['reference'] = $reference;
            if ($updates) {
                ShopProduct::where('product_id', $productId)->update($updates);

                $productName = ShopProduct::where('product_id', $productId)->value('name');

                // Registrar log
                do {
                    $logId = uniqid();
                } while (ShopLog::where('log_id', $logId)->exists());

                ShopLog::create([
                    'log_id' => $logId,
                    'user_id' => $userData->id,
                    'shop_id' => $shopData->id,
                    'details' => "Producto actualizado. Codigo numero: $product->bar_code",
                ]);

                return response()->json([
                    'status' => true,
                    'code' => 'SUCCESS_PRODUCT_UPDATED',
                    'message' => 'Producto actualizado exitosamente.',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_NO_UPDATES_PROVIDED',
                    'message' => 'No se proporcionaron datos para actualizar.'
                ], 400);
            }

        } catch (\Throwable $error) {

            dd($error);

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'method' => 'PUT',
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/product?shop_key={$shopKey}&product_id={$productId}&user_id={$userId}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }
}