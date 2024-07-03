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
        Schema::create('transfer_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->nullable();    
            $table->integer('acc_from')->nullable();    
            $table->integer('acc_to')->nullable(); 
            $table->decimal('amount', 50, 3)->nullable();
            $table->date('transfer_date')->nullable(); 
            $table->text('notes')->nullable();
            $table->string('added_by')->nullable()->nullable();  
            $table->string('updated_by')->nullable()->nullable();  
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_amounts');
    }
};
