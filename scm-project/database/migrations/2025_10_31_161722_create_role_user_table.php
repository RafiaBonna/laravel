<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            // Foreign Key to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Foreign Key to roles table
            $table->foreignId('role_id')->constrained()->onDelete('cascade'); 
            // দুটি কলামের সংমিশ্রণকে প্রাইমারি কী করা হলো (এক user-এ একই role বারবার হবে না)
            $table->primary(['user_id', 'role_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};