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
        Schema::create('pending_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pend_id')->references('id')->on('pending_orders')->onDelete('cascade');
            $table->string('customer_id')->nullable();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('store_id')->nullable();
            $table->string('item_barcode');
            $table->integer('item_quantity');
            $table->string('item_imei')->nullable();
            $table->decimal('item_discount_percent',50,2);
            $table->decimal('item_discount_price',50,3);
            $table->decimal('item_price',50,3);
            $table->decimal('item_total',50,3);
            $table->decimal('item_tax',50,3);
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
        Schema::dropIfExists('pending_order_details');
    }
};
