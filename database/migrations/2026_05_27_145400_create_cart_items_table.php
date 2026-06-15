<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();                    // ← Dùng id() thay vì uuid()
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2);
            
            $table->timestamps();

            // Ngăn user thêm cùng 1 xe nhiều lần vào giỏ
            $table->unique(['user_id', 'car_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};