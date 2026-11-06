<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('notification_id')->unique();
            $table->unsignedBigInteger('shop_id');
            $table->text('details');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_notifications');
    }
};
