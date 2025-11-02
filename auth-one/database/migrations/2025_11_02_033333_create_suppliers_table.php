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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // NN
            $table->string('email')->unique()->nullable(); // Unique Email
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            // $table->string('phone')->nullable(); // যদি আপনার প্রয়োজন হয়
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};