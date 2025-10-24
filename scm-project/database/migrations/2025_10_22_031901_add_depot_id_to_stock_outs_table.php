<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_outs', function (Blueprint $table) {
            // issued_by_user_id এর পরে যোগ করা হলো
            $table->foreignId('depot_id')->nullable()->after('raw_material_id')->constrained('depots')->onDelete('set null');

            // ⚠️ যদি আপনি আগের issued_by_user_id ফিল্ডটি মুছে ফেলতে চান:
            // $table->dropForeign(['issued_by_user_id']);
            // $table->dropColumn('issued_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('stock_outs', function (Blueprint $table) {
            // ⚠️ যদি আপনি উপরের drop করা ফিল্ডটি আবার যোগ করতে চান:
            // $table->foreignId('issued_by_user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->dropForeign(['depot_id']);
            $table->dropColumn('depot_id');
        });
    }
};

