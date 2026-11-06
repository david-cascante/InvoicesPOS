<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE LICENSIA
|--------------------------------------------------------------------------
*/
Route::prefix('license')->group(function () {
    Route::post('/', [App\Http\Controllers\License\LicenseController::class, 'storeLicense']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE TIENDA
|--------------------------------------------------------------------------
*/
Route::prefix('shop')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\ShopController::class, 'indexShop']);
    Route::get('/log', [App\Http\Controllers\Shop\ShopController::class, 'indexLog']);
    Route::post('/', [App\Http\Controllers\Shop\ShopController::class, 'storeShop']);
    Route::put('/{shop_key}', [App\Http\Controllers\Shop\ShopController::class, 'updateShop']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE CATEGORIAS
|--------------------------------------------------------------------------
*/
Route::prefix('categories')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\CategoryController::class, 'indexCategory']);
    Route::get('/search', [App\Http\Controllers\Shop\CategoryController::class, 'indexSearchCategory']);
    Route::post('/', [App\Http\Controllers\Shop\CategoryController::class, 'storeCategory']);
    Route::put('/', [App\Http\Controllers\Shop\CategoryController::class, 'updateCategory']);
    Route::delete('/', [App\Http\Controllers\Shop\CategoryController::class, 'deleteCategory']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE CLIENTES
|--------------------------------------------------------------------------
*/
Route::prefix('clients')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\ClientController::class, 'indexClient']);
    Route::get('/search', [App\Http\Controllers\Shop\ClientController::class, 'indexSearchClient']);
    Route::post('/', [App\Http\Controllers\Shop\ClientController::class, 'storeClient']);
    Route::put('/', [App\Http\Controllers\Shop\ClientController::class, 'updateClient']);
    Route::delete('/', [App\Http\Controllers\Shop\ClientController::class, 'deleteClient']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE EMPLEADOS
|--------------------------------------------------------------------------
*/
Route::prefix('employee')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\EmployeeController::class, 'indexEmployee']);
    Route::get('/search', [App\Http\Controllers\Shop\EmployeeController::class, 'indexSearchEmployee']);
    Route::post('/', [App\Http\Controllers\Shop\EmployeeController::class, 'storeEmployee']);
    Route::put('/', [App\Http\Controllers\Shop\EmployeeController::class, 'updateEmployee']);
    Route::delete('/', [App\Http\Controllers\Shop\EmployeeController::class, 'deleteEmployee']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE PROVEEDORES
|--------------------------------------------------------------------------
*/
Route::prefix('supplier')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\SupplierController::class, 'indexSupplier']);
    Route::get('/search', [App\Http\Controllers\Shop\SupplierController::class, 'indexSearchSupplier']);
    Route::post('/', [App\Http\Controllers\Shop\SupplierController::class, 'storeSupplier']);
    Route::put('/', [App\Http\Controllers\Shop\SupplierController::class, 'updateSupplier']);
    Route::delete('/', [App\Http\Controllers\Shop\SupplierController::class, 'deleteSupplier']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE PRODUCTOS
|--------------------------------------------------------------------------
*/
Route::prefix('product')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\ProductController::class, 'indexProduct']);
    Route::get('/search', [App\Http\Controllers\Shop\ProductController::class, 'indexSearchProduct']);
    Route::post('/', [App\Http\Controllers\Shop\ProductController::class, 'storeProduct']);
    Route::put('/', [App\Http\Controllers\Shop\ProductController::class, 'updateProduct']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE INVENTARIO
|--------------------------------------------------------------------------
*/
Route::prefix('inventory')->group(function () {
    Route::get('/', [App\Http\Controllers\Shop\InventoryController::class, 'indexInventory']);
    Route::get('/search', [App\Http\Controllers\Shop\InventoryController::class, 'indexSearchInventory']);
    Route::post('/', [App\Http\Controllers\Shop\InventoryController::class, 'storeInventory']);
    Route::put('/', [App\Http\Controllers\Shop\InventoryController::class, 'updateInventory']);
    Route::delete('/', [App\Http\Controllers\Shop\InventoryController::class, 'deleteInventory']);
});

/*
|--------------------------------------------------------------------------
| CONTROLADOR DE FACTURACION
|--------------------------------------------------------------------------
*/
Route::prefix('billing')->group(function () {
    Route::get('/{shop_key}/search', [App\Http\Controllers\Shop\BillingController::class, 'indexSearchBilling']);
    Route::post('/{shop_key}/preview', [App\Http\Controllers\Shop\BillingController::class, 'previewBilling']);
});