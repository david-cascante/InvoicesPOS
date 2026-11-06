<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopLog;
use App\Models\SystemLog;
use App\Models\ShopProduct;
use App\Models\ShopCategory;



class BillingController extends Controller
{
    public function indexSearchBilling(Request $request, $shop_key) : JsonResponse {

        try {
            $shopKey = $shop_key;
            $searchTerm = $request->query('search_term');
            //$apiToken = $request->bearerToken();

            if (empty(trim($shopKey)) || empty(trim($searchTerm))) {
                
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
                    'message' => "No se encontro la tienda con la clave proporcionada. Clave: {$shopKey}"
                ], 404);
            }

            // if ($shopData->api_token !== $apiToken) {
            //     return response()->json([
            //         'status' => false,
            //         'code' => 'ERR_UNAUTHORIZED',
            //         'message' => 'Acceso no autorizado. Token inválido.'
            //     ], 401);
            // }

            $product = ShopProduct::where('shop_id', $shopData->id)
                            ->where('status', true)
                            ->where(function ($query) use ($searchTerm) {
                                $query->where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('bar_code', 'LIKE', "%{$searchTerm}%");
                            })->get()
                            ->map(function ($product) {
                                return [
                                    "product_id" => $product->product_id,
                                    "name" => $product->name,
                                    "sale_price" => $product->sale_price,
                                    "tax" => $product->tax,
                                    "bar_code" => $product->bar_code,
                                ];
                            });

            if ($product->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCT_NOT_FOUND',
                    'message' => "No se encontró el producto con el término proporcionado. Término: {$searchTerm}"
                ], 404);
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_PRODUCTS_RETRIEVED',
                'message' => 'Productos obtenidos exitosamente.',
                'data' => $product
            ], 200);

        } catch (\Throwable $error) {

            do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/billing/{$shopKey}/search?search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function previewBilling(Request $request, $shop_key) : JsonResponse {
        
        try {  
            $shopKey = $shop_key;
            $products = $request->input('products');

            foreach ($products as $index => $item) {
                $productId = $item['product_id'];
                $productQuantity = $item['quantity'];
            }

            if (empty(trim($shopKey)) || empty($productId) || empty($productQuantity) ) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty($productId)) $missing[] = 'product_id';
                if (empty($productQuantity)) $missing[] = 'quantity';

                return response()->json([
                    'status' => false,
                    'code' => 'ERR_MISSING_DATA',
                    'message' => "Faltan parametros obligatorios: ". implode(', ', $missing),
                ], 400);
            }

            if (!is_numeric($productQuantity)) {
                return response()->json([
                'status' => false,
                'code' => 'ERR_INVALID_NUMBER',
                'message' => 'El valor de cantidad, debe ser un numero valido.'
            ], 400);
            }

            $shopData = Shop::where('shop_key', $shopKey)->where('status', 'active')->first();

            if(empty($shopData)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_SHOP_NOT_FOUND',
                    'message' => "No se encontro la tienda con la clave proporcionada. Clave: {$shopKey}"
                ], 404);
            }

            $tray = [];
            $total = 0;
            $tax = 0;

            foreach ($products as $item) {

                $productId = $item['product_id'];
                $productQuantity = $item['quantity'];

                $productData = ShopProduct::where('product_id', $productId)
                    ->where('shop_id', $shopData->id)
                    ->first();

                if (!$productData->continued) {
                    return response()->json([
                        'status' => false,
                        'code' => 'ERR_PRODUCT_NOT_FOR_SALE',
                        'message' => "El producto con el ID {$productId} no está a la venta."
                    ], 404);
                }

                // Si ya existe en el carrito, solo le sumamos la cantidad
                if (isset($tray[$productId])) {
                    $tray[$productId]['quantity'] += $productQuantity;
                } else {
                    // Si no existe, lo agregamos
                    $tray[$productId] = [
                        "product" => $productData->name,
                        "price" => $productData->sale_price + $productData->tax,
                        "quantity" => $productQuantity
                    ];
                }

                $total += ($productData->sale_price + $productData->tax) * $productQuantity;
                $tax += $productData->tax * $productQuantity;
            }

            return response()->json([
                "status" => true,
                "code" => "",
                "products" => array_values($tray), // opcional, para resetear índices
                "total" => $total,
                "tax" => $tax
            ]);

        } catch (\Throwable $error) {

           do {
                $systemId = uniqid();
            } while (SystemLog::where('system_id', $systemId)->exists());

            SystemLog::create([
                'system_id' => $systemId,
                'shop_id' => Shop::where('shop_key', $shopKey)->value('id'),
                'error' => $error,
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/billing/preview?shop_key={$shopKey}}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }

    }
}