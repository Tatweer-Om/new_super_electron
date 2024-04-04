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
        Schema::create('maintenance_status_histories', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('reference_no')->nullable();
            $table->integer('repair_id')->nullable();
            $table->foreignId('warranty_id')->references('id')->on('warranties')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('status')->nullable(); 
            $table->string('added_by')->nullable(); 
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_status_histories');
    }
};
