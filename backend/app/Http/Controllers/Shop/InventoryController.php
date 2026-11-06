<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Models\ShopInventory;
use App\Models\ShopLog;
use Illuminate\Support\Facades\DB;
use App\Models\SystemLog;

class InventoryController extends Controller
{
    public function indexInventory(Request $request)
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

            $inventory = ShopInventory::where('shop_id', $shopData->id)
                ->where('status', true)
                ->get()
                ->map(function ($item) {
                    return [
                        'inventory_id' => $item->inventory_id,
                        'user' => User::where('id', $item->user_id)->value('name'),
                        'product_id' => $item->product_id,
                        'productID' => ShopProduct::where('id', $item->product_id)->value('product_id'),
                        'product' => ShopProduct::where('id', $item->product_id)->value('name'),
                        'quantity' => $item->quantity,
                        'movement_type' => $item->movement_type,
                        'notes' => $item->notes,
                        'purchase_price' => $item->purchase_price,
                        'sale_price' => $item->sale_price,
                        'stock_alert' => ShopProduct::where('id', $item->product_id)->value('stock_alert'),
                        'reference' => $item->reference,
                        'status' => $item->status,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at
                    ];
                });


            if ($inventory->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_PRODUCTS_NOT_FOUND',
                    'message' => 'No hay productos registrados en esta tienda.'
                ], 404);
            }

            $products = ShopProduct::where('shop_id', $shopData->id)->get()->keyBy('id');

            $inventoryQuantity = $inventory->sum('quantity');
            $inventorySaleValue = 0;
            $inventoryPurchaseValue = 0;
            $lowStockProducts = 0;
            $productsSold = 0;
            $returnedProducts = 0;
            $lowestStockProduct = null;

            foreach ($inventory as $i => $item) {

                $product = $products->get($item['product_id']);

                $inventorySaleValue += $item['quantity'] * $item['sale_price'];
                $inventoryPurchaseValue += $item['quantity'] * $item['purchase_price'];

                if ($product && $item['quantity'] <= $product->stock_alert) {
                    $lowStockProducts++;
                    $lowestStockProduct[$i] = [
                        'product_id' => $item['product_id'],
                        'product_name' => $products[$item['product_id']]->name,
                        'quantity' => $item['quantity']
                    ];
                }

                if ($item['movement_type'] === 'sale') {
                    $productsSold++;
                }

                if ($item['movement_type'] === 'return') {
                    $returnedProducts++;
                }
            }

            $productsDiscontinued = $products->where('continued', false)->count();
            $activeProducts = $products->where('continued', true)->count();
            $lastInventoryUpdate = ShopInventory::where('shop_id', $shopData->id)->max('updated_at');
            $averageStockPerProduct = $products->count() > 0 ? $inventoryQuantity / $products->count() : 0;

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_INVENTORY_RETRIEVED',
                'message' => 'Inventario recuperado con éxito.',
                'data' => [
                    'total_quantity' => $inventoryQuantity,
                    'products_discontinued' => $productsDiscontinued,
                    'low_stock_products' => $lowStockProducts,
                    'products_sold' => $productsSold,
                    'returned_products' => $returnedProducts,
                    'inventory_sale_value' => $inventorySaleValue,
                    'inventory_purchase_value' => $inventoryPurchaseValue,
                    'lowest_stock_product' => $lowestStockProduct,
                    'active_products' => $activeProducts,
                    'last_inventory_update' => $lastInventoryUpdate,
                    'average_stock_per_product' => $averageStockPerProduct,
                    'inventory' => $inventory,
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/inventory?shop_key={$shopKey}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function indexSearchInventory(Request $request) {

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
                ->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->get()
                ->keyBy('id');

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_NO_PRODUCTS_FOUND',
                    'message' => 'No se encontraron productos que coincidan con el término de búsqueda.'
                ], 404);
            }

            $inventory = ShopInventory::where('shop_id', $shopData->id)
                ->whereIn('product_id', $products->keys())
                ->get()
                ->groupBy('product_id');

            $result = [];

            foreach ($products as $productId => $product) {
                $productInventory = $inventory->get($productId, collect());

                $totalQuantity = $productInventory->sum('quantity');
                $averageSalePrice = $productInventory->avg('sale_price');
                $averagePurchasePrice = $productInventory->avg('purchase_price');

                $result[] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'description' => $product->description,
                    'total_quantity' => $totalQuantity,
                    'average_sale_price' => round($averageSalePrice, 2),
                    'average_purchase_price' => round($averagePurchasePrice, 2),
                    'stock_alert' => $product->stock_alert,
                    'continued' => $product->continued,
                ];
            }

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_PRODUCTS_FOUND',
                'message' => 'Productos encontrados con éxito.',
                'data' => $result
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
                'endpoint' => env('APP_URL')."/".env('API_VERSION')."/inventory/search?shop_key={$shopKey}&search_term={$searchTerm}"
            ]);

            return response()->json([
                'status' => false,
                'code' => 'ERR_SYSTEM_NOT_RESPONSE',
                'message' => 'El sistema no pudo responder a tu petición. El equipo de soporte técnico ha sido notificado y esta solucionándolo.'
            ], 500);
        }
    }

    public function updateInventory(Request $request) {
    
        try {
            $shopKey = $request->query('shop_key');
            $userId = $request->query('user_id');
            $inventoryId = $request->query('inventory_id');
            $quantity = $request->query('quantity');

            //$apiToken = $request->bearerToken();
 
            //empty(trim($apiToken))

            if (empty(trim($shopKey)) || empty(trim($userId)) || empty(trim($inventoryId))) {
                
                $missing = [];
                if (empty(trim($shopKey))) $missing[] = 'shop_key';
                if (empty(trim($userId))) $missing[] = 'user_id';
                if (empty(trim($inventoryId))) $missing[] = 'inventory_id';
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

            if (!is_numeric($quantity)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_QUANTITY',
                    'message' => 'La cantidad debe ser un número.'
                ], 400);
            }

            if ($quantity <= 0) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_QUANTITY',
                    'message' => 'La cantidad debe ser un número positivo.'
                ], 400);
            }

            $product = ShopInventory::where('inventory_id', $inventoryId)
                ->where('shop_id', $shopData->id)
                ->where('status', true)
                ->first();

            if (empty($product)) {
                return response()->json([
                    'status' => false,
                    'code' => 'ERR_INVALID_PRODUCT',
                    'message' => 'El producto no es válido.'
                ], 400);
            }

            ShopInventory::where('inventory_id', $inventoryId)
                ->update(['quantity' => DB::raw("quantity + $quantity"), 'movement_type' => 'adjustment']);

            do {
                $logId = uniqid();
            } while (ShopLog::where('log_id', $logId)->exists());

            ShopLog::create([
                'log_id' => $logId,
                'user_id' => $userData->id,
                'shop_id' => $shopData->id,
                'details' => "Producto ID {$inventoryId} actualizado a cantidad {$quantity} por API.",
            ]);

            return response()->json([
                'status' => true,
                'code' => 'SUCCESS_INVENTORY_UPDATED',
                'message' => 'Inventario actualizado con éxito.'
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
}
