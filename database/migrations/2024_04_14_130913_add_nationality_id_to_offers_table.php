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
        Schema::table('offers', function (Blueprint $table) {
            $table->text('nationality_id')->nullable();
            $table->integer('offer_type_student')->nullable();
            $table->integer('offer_type_employee')->nullable();
            $table->text('university_id')->nullable();
            $table->text('ministry_id')->nullable();
            $table->text('workplace_id')->nullable(); 
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            //
        });
    }
};
