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
        Schema::create('localrepairproducts', function (Blueprint $table) {
             
            $table->id(); 
            $table->string('reference_no')->nullable();
            $table->integer('repair_id')->nullable();
            $table->string('warranty_reference_no')->nullable();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('cost',50,3); 
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
        Schema::dropIfExists('localrepairproducts');
    }
};
