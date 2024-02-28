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
        Schema::create('payment__expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('pos_orders')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('total_amount');
            $table->string('bank_name');
            $table->string('payment_type');
            $table->string('bank_tax')->nullable();
            $table->string('bank_fee')->nullable();
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
        Schema::dropIfExists('payment__expenses');
    }
};
