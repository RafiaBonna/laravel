<?php

// .../database/migrations/..._add_total_cost_to_product_receives_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_receives', function (Blueprint $table) {
            // নতুন কলাম যোগ
            $table->decimal('total_cost', 15, 2)->default(0)->after('total_received_qty'); 
        });
    }

    public function down(): void
    {
        Schema::table('product_receives', function (Blueprint $table) {
            // কলাম অপসারণ
            $table->dropColumn('total_cost');
        });
    }
};
