<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shop_id');
            $table->enum('document_type', ['dni', 'passport', 'driver_license']);
            $table->string('identification');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->float('credits')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_clients');
    }
};
