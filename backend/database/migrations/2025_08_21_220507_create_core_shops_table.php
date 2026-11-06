<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('license_id');
            $table->string('shop_key')->unique();
            $table->string('api_token', 80)->unique();
            $table->string('name');
            $table->string('type')->default('none');
            $table->string('currency')->default('CRC');
            $table->string('ip_address');
            $table->boolean('credits')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('license_id')->references('id')->on('licenses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
