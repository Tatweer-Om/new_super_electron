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
        Schema::create('localmaintenances', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('warranty_reference_no')->nullable();
            $table->string('receive_date')->nullable();
            $table->string('deliver_date')->nullable();
            $table->integer('repairing_type')->nullable();
            $table->text('technician_id')->nullable();
            $table->text('notes')->nullable();
            $table->integer('status')->default(1)->comment('1: recieve, 4:ready, 5:deleivered');
            $table->integer('review_by')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localmaintenances');
    }
};
