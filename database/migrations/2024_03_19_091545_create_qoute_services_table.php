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
        Schema::create('qoute_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('qoute_id')->constrained('qoutations')->onDelete('cascade');
            $table->string('customer_id')->nullable();
            $table->string('service_id');
            $table->decimal('service_price', 50, 3);
            $table->integer('service_quantity')->nullable();
            $table->decimal('total_price', 50, 3);
            $table->text('service_detail')->nullable();
            $table->string('service_warranty')->nullable();
            $table->string('user_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('added_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qoute_services');
    }
};
