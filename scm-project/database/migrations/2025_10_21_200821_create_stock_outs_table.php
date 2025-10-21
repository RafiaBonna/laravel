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
            
            // Foreign Key to RawMaterial Master
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade'); 
            
            // Quantity issued/consumed
            $table->decimal('issued_quantity', 10, 2); 
            
            // Unit of the material
            $table->string('unit'); 
            
            // Optional: User/Department/Purpose of issue
            $table->string('purpose')->nullable();
            
            // Date of issue (default to current date)
            $table->date('issue_date')->useCurrent(); 

            $table->timestamps();
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