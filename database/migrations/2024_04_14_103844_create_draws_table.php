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
        Schema::create('draws', function (Blueprint $table) {
            $table->id();
            $table->string('draw_id', 255)->unique();
            $table->string('draw_name')->nullable();
            $table->string('draw_date')->nullable();
            $table->string('draw_starts')->nullable();
            $table->string('draw_ends')->nullable();
            $table->text('draw_detail')->nullable();
            $table->text('nationality_id')->nullable();
            $table->text('university_id')->nullable();
            $table->text('ministry_id')->nullable();
            $table->text('workplace_id')->nullable();
            $table->text('male')->nullable();
            $table->text('female')->nullable();
            $table->text('draw_type_employee')->nullable();
            $table->text('draw_type_student')->nullable();
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
        Schema::dropIfExists('draws');
    }
};
