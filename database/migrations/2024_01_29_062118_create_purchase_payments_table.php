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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->string('invoice_no')->nullable();
            $table->decimal('total_price',50,3)->nullable();
            $table->decimal('paid_amount',50,3)->nullable();
            $table->decimal('remaining_price',50,3)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_reference_no')->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('purchase_payments');
    }
};
