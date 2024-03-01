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
        Schema::create('pos_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('pos_orders')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade')->nullable();
            $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('item_barcode');
            $table->integer('item_quantity');
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
        Schema::dropIfExists('pos_order_details');
    }
};
