// database/migrations/2025_10_23_043026_create_posts_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // <-- ADDED
            $table->string('title'); // <-- ADDED
            $table->text('body'); // <-- ADDED
            $table->timestamps();
        });
    }
// ...
};