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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_id')->unique();
            $table->string('offer_name');
            $table->string('offer_start_date')->nullable();
            $table->string('offer_discount')->nullable();
            $table->string('offer_discount_type')->nullable();
            $table->string('offer_end_date')->nullable();
            $table->string('offer_product_ids')->nullable();
            $table->string('offer_brand_ids')->nullable();
            $table->string('offer_category_ids')->nullable();
            $table->string('offer_type')->nullable();
            $table->string('offer_apply')->nullable();
            $table->text('offer_detail')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
