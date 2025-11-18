<?php

// .../database/migrations/..._add_total_item_cost_to_product_receive_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_receive_items', function (Blueprint $table) {
            // নতুন কলাম যোগ
            $table->decimal('total_item_cost', 15, 2)->default(0)->after('cost_rate');
        });
    }

    public function down(): void
    {
        Schema::table('product_receive_items', function (Blueprint $table) {
            // কলাম অপসারণ
            $table->dropColumn('total_item_cost');
        });
    }
};
