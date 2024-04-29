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
            $table->decimal('item_profit', 50, 3)->nullable(); // Change 'some_column' to the column after which you want to add 'amount'

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