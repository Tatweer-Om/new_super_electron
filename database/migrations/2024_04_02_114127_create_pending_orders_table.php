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
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('store_id')->nullable();
            $table->integer('item_count');
            $table->decimal('paid_amount',50,3)->nullable();
            $table->decimal('total_amount',50,3)->nullable();
            $table->integer('discount_type')->nullable;
            $table->integer('discount_by')->nullable;
            $table->decimal('total_tax',50,3);
            $table->decimal('total_discount',50,3);
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
        Schema::dropIfExists('pending_orders');
    }
};
