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
        // Pivot Table-এর নাম Laravel Convention অনুযায়ী 'student_subject'
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();

            // Foreign Key for students table
            $table->foreignId('student_id')
                  ->constrained() // students table-এর সাথে সম্পর্ক স্থাপন
                  ->onDelete('cascade'); // Student delete হলে pivot entry delete হবে

            // Foreign Key for subjects table
            $table->foreignId('subject_id')
                  ->constrained() // subjects table-এর সাথে সম্পর্ক স্থাপন
                  ->onDelete('cascade'); // Subject delete হলে pivot entry delete হবে
            
            // একটি ছাত্র যেন একই সাবজেক্ট একাধিকবার না নিতে পারে তার জন্য unique constraint 
            $table->unique(['student_id', 'subject_id']); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject');
    }
};