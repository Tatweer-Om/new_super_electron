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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('area_name')->nullable();
            $table->string('added_by')->nullable();
            $table->timestamps();
        });

        // Insert Omani areas into the database
        $omanAreas = [
            ['area_name' => 'Ad Dakhiliyah', 'added_by' => 'admin'],
            ['area_name' => 'Ad Dhahirah', 'added_by' => 'admin'],
            ['area_name' => 'Al Batinah North', 'added_by' => 'admin'],
            ['area_name' => 'Al Batinah South', 'added_by' => 'admin'],
            ['area_name' => 'Al Buraimi', 'added_by' => 'admin'],
            ['area_name' => 'Al Wusta', 'added_by' => 'admin'],
            ['area_name' => 'Ash Sharqiyah North', 'added_by' => 'admin'],
            ['area_name' => 'Ash Sharqiyah South', 'added_by' => 'admin'],
            ['area_name' => 'Dhofar', 'added_by' => 'admin'],
            ['area_name' => 'Musandam', 'added_by' => 'admin'],
            ['area_name' => 'Muscat', 'added_by' => 'admin'],
        ];

        // Insert Omani areas into the database
        foreach ($omanAreas as $area) {
            DB::table('addresses')->insert($area);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
