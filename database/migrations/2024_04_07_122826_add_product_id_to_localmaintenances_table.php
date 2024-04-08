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
        Schema::table('localmaintenances', function (Blueprint $table) {
            $table->string('product_name')->nullable();
            $table->string('category_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->integer('imei_no')->nullable();
            $table->integer('inspection_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('localmaintenances', function (Blueprint $table) {
            //
        });
    }
};
