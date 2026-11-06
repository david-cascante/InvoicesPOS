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
        Schema::create('system_log', function (Blueprint $table) {
            $table->id();
            $table->string('system_id')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->text('error');
            $table->enum('method', ['GET', 'POST', 'PUT', 'DELETE']);
            $table->string('endpoint')->nullable();
            $table->enum('status', ['fixed', 'unfixed', 'in_progress'])->default('unfixed');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_log');
    }
};
