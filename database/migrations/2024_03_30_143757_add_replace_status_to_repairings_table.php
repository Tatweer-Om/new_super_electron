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
        Schema::table('repairings', function (Blueprint $table) {
            $table->integer('replace_status')->default(1)->comment('1: not repalced, 2: Replaced');
            $table->integer('review_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairings', function (Blueprint $table) {
            //
        });
    }
};
