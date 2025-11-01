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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->unsignedBigInteger('depot_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();

            // Foreign keys (optional, if related tables exist)
            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('set null');
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
