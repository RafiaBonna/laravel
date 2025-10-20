<?php

// database/migrations/*_create_stock_ins_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade'); 
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); 

            $table->decimal('received_quantity', 10, 2); 
            $table->string('unit'); 
            $table->decimal('unit_price', 10, 2)->nullable(); 
            $table->date('received_date')->useCurrent(); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};