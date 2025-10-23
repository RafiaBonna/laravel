// database/migrations/YYYY_MM_DD_add_country_id_to_users_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::table ব্যবহার করা হয়েছে কারণ users টেবিলটি আগেই তৈরি হয়েছে।
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->constrained(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });
    }
};