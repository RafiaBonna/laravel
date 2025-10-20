<?php

// database/migrations/*_create_raw_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('unit')->default('pcs'); 
            $table->decimal('current_stock', 10, 2)->default(0); // এটি আপডেট হবে
            $table->decimal('alert_stock', 10, 2)->default(10); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
