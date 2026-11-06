<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('sale_price', 12, 2);
            $table->integer('units');
            $table->enum('unit_measurement', ['unit', 'piece', 'box', 'pack', 'liter', 'ml', 'gallon', 'kg', 'g', 'pound']);
            $table->string('bar_code')->unique();
            $table->text('image_path')->nullable();
            $table->integer('stock_alert');
            $table->decimal('tax', 10, 2);
            $table->boolean('continued')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('category_id')->references('id')->on('shop_categories');
            $table->foreign('supplier_id')->references('id')->on('shop_suppliers');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};