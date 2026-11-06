<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('license_key')->unique();
            $table->enum('plan', ['basic', 'standard', 'premium']);
            $table->enum('duration', ['1_month', '3_month', '6_month', '1_year']);
            $table->string('transaction_paypal_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['activated', 'expired', 'pending', 'canceled'])->default('pending');
            $table->string('ip_address');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
