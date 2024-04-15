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
            $table->decimal('inspection_cost', 50, 3)->nullable()->change();
            $table->text('imei_no')->nullable()->change();
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
