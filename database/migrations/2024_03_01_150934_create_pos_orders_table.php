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
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade')->nullable();
            $table->integer('item_count');
            $table->decimal('paid_amount',50,3);
            $table->decimal('total_amount',50,3);
            $table->integer('discount_type')->nullable;
            $table->integer('discount_by')->nullable;
            $table->decimal('total_tax',50,3);
            $table->decimal('total_discount',50,3);
            $table->decimal('cash_back' ,50,3);
            $table->integer('return_status')->default(1);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('pos_orders');
    }
};
