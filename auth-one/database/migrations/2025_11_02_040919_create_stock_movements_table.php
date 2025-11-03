<?php
// database/migrations/..._create_stock_movements_table.php

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
        // ✅ Stock In এবং Stock Out এর ইতিহাস রাখার টেবিল
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('raw_material_id')->constrained('raw_materials'); // কোন মেটেরিয়াল
            
            $table->enum('type', ['IN', 'OUT']); // মুভমেন্ট টাইপ (ইনভয়েস বা কনসাম্পশন)
            $table->decimal('quantity', 10, 2); // পরিমাণের রেকর্ড
            
            // Polymorphic Reference: কোন ডকুমেন্ট থেকে এসেছে তা চিহ্নিত করার জন্য
            $table->string('reference_type'); 
            $table->unsignedBigInteger('reference_id'); 

            $table->foreignId('user_id')->constrained('users'); // যিনি মুভমেন্ট রেকর্ড করেছেন
            
            $table->timestamps();
            
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};