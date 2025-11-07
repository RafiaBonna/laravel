<?php

// database/migrations/2025_11_07_202101_remove_role_column_from_users_table.php

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
        Schema::table('users', function (Blueprint $table) {
            // ✅ Many-to-Many ব্যবহার করার কারণে পুরনো role কলামটি মুছে ফেলা হচ্ছে
            $table->dropColumn('role'); 
            // ✅ status কলামও role কলামের সাথে যুক্ত ছিল, তাই এটিও মুছে ফেলা হচ্ছে
            // আপনি যদি স্ট্যাটাস কলামটি রাখতে চান, তবে এটি বাদ দিতে পারেন
            $table->dropColumn('status'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             // Rollback-এর জন্য, কলাম দুটি আবার যোগ করতে হবে
             $table->enum('role', ['superadmin', 'depo', 'distributor', 'admin', 'user'])->default('user')->after('password');
             $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
        });
    }
};
