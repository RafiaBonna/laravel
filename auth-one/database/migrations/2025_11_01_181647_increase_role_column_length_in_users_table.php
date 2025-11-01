<?php

// database/migrations/..._increase_role_column_length_in_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role কলামের বর্তমান দৈর্ঘ্য পরিবর্তন করে 25 করা হলো
            // change() ব্যবহার করার জন্য 'doctrine/dbal' প্যাকেজটি ইনস্টল থাকতে হবে।
            $table->string('role', 25)->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // এটি rollback এর জন্য। যদি বর্তমান দৈর্ঘ্য 10 বা অন্য কিছু থাকে, তবে তা এখানে দিতে হবে। 
            // যেহেতু সঠিক পুরোনো দৈর্ঘ্য জানা নেই, আপনি এটিকে 10 রাখতে পারেন।
            $table->string('role', 10)->change(); 
        });
    }
};