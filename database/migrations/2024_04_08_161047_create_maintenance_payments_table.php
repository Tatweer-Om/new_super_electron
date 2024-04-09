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
        Schema::create('maintenance_payments', function (Blueprint $table) {
            $table->id();
            $table->string('referemce_no')->nullable();            
            $table->integer('repair_id')->nullable();            
            $table->integer('customer_id')->nullable();
            $table->string('store_id')->nullable();
            $table->decimal('paid_amount',50,3);
            $table->decimal('total',50,3);
            $table->decimal('remaining_amount',50,3);
            $table->string('account_id');
            $table->string('account_reference_no');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('maintenance_payments');
    }
};
