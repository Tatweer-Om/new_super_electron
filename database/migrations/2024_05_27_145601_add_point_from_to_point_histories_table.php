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
        Schema::table('point_histories', function (Blueprint $table) {
            $table->integer('point_from')->nullable()->comment('1: pos, 2: local maintenance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('point_histories', function (Blueprint $table) {
            //
        });
    }
};
