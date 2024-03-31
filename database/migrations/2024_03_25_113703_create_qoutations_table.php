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
        Schema::create('qoutations', function (Blueprint $table) {
            $table->id();
            // $table->string('quote_no')->nullable();
            $table->string('customer_id')->nullable();
            $table->decimal('sub_total', 50,3)->nullable();
            $table->decimal('total_amount', 50,3)->nullable();
            $table->decimal('paid_amount', 50,3)->nullable();
            $table->decimal('remaining_amount', 50,3)->nullable();
            $table->decimal('shipping', 50,3)->nullable();
            // $table->decimal('tax', 50,3)->nullable();
            $table->date('date')->nullable();
            $table->string('store_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('added_by')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qoutations');
    }
};
