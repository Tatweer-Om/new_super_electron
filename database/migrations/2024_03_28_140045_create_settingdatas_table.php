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
        Schema::create('settingdatas', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('cr_no')->nullable();
            $table->string('main_logo')->nullable();
            $table->string('invo_logo')->nullable();
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
        Schema::dropIfExists('settingdatas');
    }
};
