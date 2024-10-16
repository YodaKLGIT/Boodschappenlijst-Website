<?php

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
        Schema::create('user_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Foreign key for the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign key for the lists table
            $table->foreignId('list_id')->constrained()->onDelete('cascade');

            // Ensure the combination of user_id and list_id is unique
            $table->unique(['user_id', 'list_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lists');
    }
};
