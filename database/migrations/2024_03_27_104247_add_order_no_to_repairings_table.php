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
            $table->string('invoice_no')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('receive_date')->nullable();
            $table->string('deliver_date')->nullable();
            $table->integer('repairing_type')->nullable();
             $table->text('technician_id')->nullable();
            $table->text('notes')->nullable();
            $table->integer('status')->default(1)->comment('1: recieve, 2: send to agent, 3: receive from agent, 4:ready, 5:deleivered');
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id', 255)->nullable();
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
