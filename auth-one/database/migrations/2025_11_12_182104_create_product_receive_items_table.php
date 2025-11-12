<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_product_receive_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_receive_items', function (Blueprint $table) {
            $table->id();
            // product_receives টেবিলের সাথে সম্পর্ক
            $table->foreignId('product_receive_id')->constrained('product_receives')->onDelete('cascade'); 
            // products টেবিলের সাথে সম্পর্ক
            $table->foreignId('product_id')->constrained('products'); 
            
            $table->string('batch_no')->nullable(); // উৎপাদনের ব্যাচ নম্বর
            $table->date('production_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('received_quantity', 15, 2);
            $table->decimal('cost_rate', 15, 2)->nullable(); // উৎপাদন খরচ (ঐচ্ছিক)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_receive_items');
    }
};
