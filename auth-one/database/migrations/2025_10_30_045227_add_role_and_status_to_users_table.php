<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (মাইগ্রেশন রান হলে কলাম যোগ হবে)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role কলামটি password কলামের পরে যুক্ত করা হলো
            $table->enum('role', ['admin', 'vendor', 'customer', 'rider'])->default('customer')->index()->after('password');
            
            // status কলামটি role কলামের পরে যুক্ত করা হলো
            $table->enum('status', ['active', 'inactive'])->default('active')->index()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     * (মাইগ্রেশন রোলব্যাক হলে কলাম দুটি বাদ যাবে)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('status');
        });
    }
};