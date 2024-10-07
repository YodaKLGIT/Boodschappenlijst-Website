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
        Schema::create('product_list', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("quantity")->default(0); // Add the amount here

            // Foreign key for the products table
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Foreign key for the lists table
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade'); // Ensure it references the correct table
            
            // Ensure the combination of product_id and list_id is unique
            $table->unique(['product_id', 'list_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_list');
    }
};
