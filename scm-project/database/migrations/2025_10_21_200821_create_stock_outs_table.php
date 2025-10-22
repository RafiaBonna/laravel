<?php

// database/migrations/2025_10_22_094000_create_stock_outs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys (raw_material ও depot/destination এর সাথে সম্পর্ক)
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade'); 
            $table->foreignId('depot_id')->nullable()->constrained('depots')->onDelete('set null'); // ধরে নিলাম depot_id আছে
            
            $table->decimal('issued_quantity', 10, 2); 
            $table->string('unit'); 
            $table->decimal('cost_price', 10, 2)->nullable(); // Stock Out-এর সময় দামের প্রয়োজন হতে পারে (ঐচ্ছিক)
            $table->date('issued_date')->useCurrent(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};