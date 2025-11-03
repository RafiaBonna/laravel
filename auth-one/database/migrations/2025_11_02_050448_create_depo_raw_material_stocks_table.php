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
        Schema::create('depo_raw_material_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('depo_id')->constrained('depos')->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade');
            $table->decimal('current_stock', 12, 2)->default(0);
            
            // নিশ্চিত করা যাতে একই Depo-তে একই Material দুইবার না থাকে
            $table->unique(['depo_id', 'raw_material_id']); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depo_raw_material_stocks');
    }
};
