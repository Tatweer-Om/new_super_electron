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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('product_barcode');
            $table->integer('product_quantity');
            $table->decimal('product_total',50,3)->nullable();
            $table->decimal('product_discount',50,3)->nullable();
            $table->string('product_tax',50,3)->nullable();
            $table->decimal('sub_total',50,3)->nullable();
            $table->decimal('total_discount',50,3)->nullable();
            $table->decimal('total_tax',50,3)->nullable();
            $table->decimal('grand_total',50,3)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_reference_no')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->integer('bulk_quantity')->nullable();
            $table->decimal('bulk_price',50,3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
