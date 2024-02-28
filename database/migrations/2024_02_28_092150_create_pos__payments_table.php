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
        Schema::create('pos__payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->foreignId('order_id')->references('id')->on('pos_orders')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->decimal('paid_amount',50,3);
            $table->decimal('total',50,3);
            $table->string('bank_name');
            $table->string('payment_type');
            $table->string('notes')->nullable();
            $table->integrr('return_status')->default(1);
            $table->date('add_date')->nullable();
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
        Schema::dropIfExists('pos__payments');
    }
};
