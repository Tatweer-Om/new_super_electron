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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_image')->nullable();
            $table->string('national_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->integer('customer_type')->nullable()->comment('1: Students, 2: Teachers 3:Employees 4:General_Customer');
            $table->string('student_id')->nullable();
            $table->string('student_university')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('employee_workplace')->nullable();
            $table->string('teacher_university')->nullable();
            $table->text('customer_detail')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
