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
        Schema::create('pos__orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->integer('item_count');
            $table->decimal('paid_amount',50,3);
            $table->decimal('total_amount',50,3);
            $table->string('discount_type')->nullable;
            $table->decimal('total_tax',50,3);
            $table->decimal('total_discount',50,3);
            $table->decimal('cash_back' ,50,3);
            $table->string('payment_note')->nullable();
            $table->string('payment_method');
            $table->text('notes')->nullable();
            $table->date('add_date')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->timestamps();

            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos__orders');
    }
};
