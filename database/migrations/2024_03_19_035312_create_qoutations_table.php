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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quote_no'); // Corrected typo in column name
            $table->date('date');
            $table->decimal('total_amount', 20, 3); // Changed precision to 20
            $table->decimal('paid_amount', 20, 3); // Changed precision to 20
            $table->decimal('remaining_amount', 20, 3); // Changed precision to 20
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qoutations');
    }
};
