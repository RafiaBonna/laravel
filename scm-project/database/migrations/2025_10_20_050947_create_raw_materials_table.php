<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🛑 CRITICAL FIX: এখানে অবশ্যই Schema::create ব্যবহার করতে হবে, Schema::table নয়।
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('unit')->default('pcs'); 
            
            // ✅ FIX: current_stock কলামটি তৈরির সময় এখানে যোগ করা হলো
            $table->decimal('current_stock', 10, 2)->default(0); 
            
            $table->decimal('alert_stock', 10, 2)->default(10); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};