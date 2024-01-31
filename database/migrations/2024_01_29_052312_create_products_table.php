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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreignId('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreignId('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('product_name')->nullable();
            $table->string('product_name_ar')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('purchase_price',50,3)->nullable();
            $table->decimal('profit_percent',50,3)->nullable();
            $table->decimal('sale_price',50,3)->nullable();
            $table->decimal('min_sale_price',50,3)->nullable();
            $table->integer('tax')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('notification_limit')->nullable();
            $table->integer('product_type')->nullable()->comment('1: Retail, 2: Spare Parts');
            $table->integer('warranty_type')->nullable()->comment('1: Shop, 2: Agent, 3: None');
            $table->integer('warranty_days')->nullable();
            $table->integer('whole_sale')->nullable();
            $table->integer('bulk_quantity')->nullable();
            $table->decimal('bulk_price',50,3)->nullable();
            $table->integer('check_imei')->nullable();
            $table->text('description')->nullable();
            $table->string('stock_image')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
