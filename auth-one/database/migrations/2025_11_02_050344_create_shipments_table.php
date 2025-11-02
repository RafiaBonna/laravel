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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            
            // Raw Material Details
            $table->foreignId('raw_material_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost', 10, 2)->nullable(); 
            $table->enum('shipment_type', ['RAW_MATERIAL', 'FINISHED_PRODUCT']); 
            
            // Destination
            $table->foreignId('depo_id')->constrained('depos')->onDelete('cascade');
            
            // Status and Tracking
            $table->enum('status', ['PENDING', 'SHIPPED', 'RECEIVED', 'CANCELLED'])->default('PENDING');
            $table->date('shipment_date');
            $table->date('received_date')->nullable();
            $table->string('driver_name')->nullable();
            
            // User IDs
            $table->foreignId('user_id')->constrained('users')->comment('Shipped by Superadmin User');
            $table->foreignId('receiver_user_id')->nullable()->constrained('users')->comment('Received by Depo User');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
