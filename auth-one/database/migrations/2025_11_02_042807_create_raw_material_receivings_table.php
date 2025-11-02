<?php
// database/migrations/..._create_raw_material_receivings_table.php

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
        // ✅ Raw Material Receiving (Invoice/Details Record) টেবিল
        Schema::create('raw_material_receivings', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // ইনভয়েস নম্বর
            
            // Foreign Keys
            $table->foreignId('supplier_id')->constrained('suppliers'); 
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->foreignId('user_id')->constrained('users'); 

            $table->decimal('quantity', 10, 2); // পরিমাণ
            $table->decimal('unit_cost', 10, 2); // প্রতি ইউনিটের খরচ
            $table->date('receiving_date'); // প্রাপ্তির তারিখ
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_receivings');
    }
};