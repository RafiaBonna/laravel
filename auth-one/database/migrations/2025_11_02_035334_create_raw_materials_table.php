<?php
// database/migrations/..._create_raw_materials_table.php

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
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Raw Material-এর নাম
            $table->string('unit', 50); // পরিমাপের একক (kg, pcs, liters)
            $table->decimal('current_stock', 10, 2)->default(0); // বর্তমান স্টক
            $table->decimal('alert_stock', 10, 2)->default(0); // অ্যালার্ট স্টক লেভেল
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};