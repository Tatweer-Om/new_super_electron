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
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();            
            $table->integer('order_id')->nullable();
            $table->integer('customer_id')->nullable(); 
            $table->string('account_id')->nullable();
            $table->decimal('amount', 50, 3)->nullable();
            $table->string('points')->nullable()->nullable();
            $table->integer('type')->nullable()->nullable();
            $table->integer('point_percent')->nullable()->nullable();
            $table->string('added_by')->nullable()->nullable(); 
            $table->string('user_id', 255)->nullable()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_histories');
    }
};
