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
        Schema::create('draw_singles', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('draw_id')->references('id')->on('draws')->onDelete('cascade');   
            $table->string('luckydraw_no')->nullable();    
            $table->integer('winner_id')->nullable();    
            $table->string('gift')->nullable(); 
            $table->date('draw_date')->nullable(); 
            $table->integer('status')->default(1)->comment('1: New, 2: Completed'); 
            $table->string('added_by')->nullable()->nullable(); 
            $table->string('winning_time')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draw_singles');
    }
};
