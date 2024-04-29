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
        Schema::table('pos_order_details', function (Blueprint $table) {
            $table->integer('offer_discount_percent')->nullable();
            $table->decimal('offer_discount_amount', 50, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_order_details', function (Blueprint $table) {
            //
        });
    }
};
