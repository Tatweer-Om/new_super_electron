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
        Schema::table('purchases', function (Blueprint $table) {
            $table->integer('tax_type')->nullable()->comment('1: No Tax, 2: with Tax');
            $table->integer('available_tax_type')->nullable()->comment('1: non refundable, 2: refundable');
            $table->integer('bulk_tax')->nullable();
            $table->integer('tax_status')->nullable()->comment('1: not active tax, 2: active tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
};
