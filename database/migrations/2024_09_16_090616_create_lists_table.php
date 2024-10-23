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
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique(); 
            $table->foreignId('theme_id')->nullable()->constrained()->onDelete('cascade'); // Make theme_id nullable
            $table->timestamps();
             // Add the unique constraint
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');  // Changed 'list' to 'lists' to match the create method
    }
};
