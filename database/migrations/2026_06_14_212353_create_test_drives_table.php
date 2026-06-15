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
    Schema::create('test_drives', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->string('phone');
        $table->string('email')->nullable();
        $table->foreignId('car_id')->nullable()->constrained('cars')->nullOnDelete();
        $table->date('preferred_date')->nullable();
        $table->text('message')->nullable();
        $table->enum('status', ['pending', 'contacted', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_drives');
    }
};
