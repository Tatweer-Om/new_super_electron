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
        Schema::create('draw_winners', function (Blueprint $table) {
            $table->id();
            $table->integer('draw_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('added_by')->nullable(); 
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draw_winners');
    }
};
