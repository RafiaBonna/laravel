<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // নিশ্চিত করুন যে users টেবিলটি ডিলিট হয়েছে
        Schema::dropIfExists('users'); 

        // ✅ নতুন users টেবিল তৈরি করা হচ্ছে (role_id সহ)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // role_id কলাম যোগ করা হলো
            $table->foreignId('role_id')
                  ->default(1) // ডিফল্ট রোল ID সেট করুন (মনে রাখবেন: ID=1 রোলটি অবশ্যই থাকতে হবে)
                  ->constrained('roles') // roles টেবিলের সাথে ফরেন কী রিলেশন
                  ->onDelete('cascade'); 

            $table->rememberToken();
            $table->timestamps();
        });

        // আপনার অন্যান্য ডিফল্ট টেবিলগুলি তৈরি করুন (যদি না থাকে)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};