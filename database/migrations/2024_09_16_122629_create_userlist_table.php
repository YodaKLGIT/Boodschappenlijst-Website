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
        Schema::create('user_list', function (Blueprint $table) {
            $table->id();

            // Foreign key for the users table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Foreign key for the lists table
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');

         
            // Ensure the combination of user_id and list_id is unique
            $table->unique(['user_id', 'list_id']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_list');
    }
};