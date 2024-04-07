<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->id();
            $table->string('authuser_id')->unique();
            $table->string('authuser_name')->nullable();
            $table->string('authuser_username')->nullable();
            $table->string('authuser_password')->nullable();
            $table->string('store_id')->nullable();
            $table->string('authuser_phone')->nullable();
            $table->string('authuser_image')->nullable();
            $table->text('authuser_detail')->nullable();
            $table->text('permit_type')->nullable();
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
        Schema::dropIfExists('auth_users');
    }
};

