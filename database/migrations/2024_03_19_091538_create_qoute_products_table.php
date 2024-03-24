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
        Schema::create('qoute_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('qoute_id')->constrained('qoutations')->onDelete('cascade');
            $table->string('customer_id')->nullable();;
            $table->string('product_id');
            $table->decimal('product_price' ,50,3);
            $table->integer('product_quantity')->nullable();
            $table->decimal('total_price' ,50,3);
            $table->text('product_detail')->nullable();
            $table->string('product_warranty')->nullable();
            $table->string('warranty_type')->nullable();
            $table->string('warranty_days')->nullable();
            $table->string('user_id');
            $table->string('store_id');
            $table->string('added_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qoute_products');
    }
};
