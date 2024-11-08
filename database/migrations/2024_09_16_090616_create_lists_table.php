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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Add this line
            $table->foreignId('theme_id')->nullable()->constrained()->onDelete('cascade'); // Make theme_id nullable
            $table->boolean('is_favorite')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};