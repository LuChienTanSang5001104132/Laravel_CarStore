<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();                    // ← Dùng id() thay vì uuid()
            
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 15, 2);
            $table->integer('year');
            $table->string('color')->nullable();
            $table->string('type'); 
            $table->integer('quantity')->default(1);
            $table->integer('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->integer('seats')->nullable();
            
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};