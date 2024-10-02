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
        Schema::create('user_shopping_list', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID

            // Foreign key for the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Delete all user associations if user is deleted

            // Foreign key for the lists table
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade'); // Delete all list associations if list is deleted



            $table->timestamps(); 

            // Ensure the combination of user_id and list_id is unique
            $table->unique(['user_id', 'list_id'], 'user_list_unique'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shopping_list'); // Drops the table on rollback
    }
};
