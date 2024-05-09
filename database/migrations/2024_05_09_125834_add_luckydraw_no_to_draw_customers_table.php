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
        Schema::table('draw_customers', function (Blueprint $table) {
            $table->string('luckydraw_no')->nullable();  
            $table->integer('draw_single_id')->nullable(); 
            $table->integer('draw_date')->nullable(); 
            $table->integer('gift')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('draw_customers', function (Blueprint $table) {
            //
        });
    }
};
