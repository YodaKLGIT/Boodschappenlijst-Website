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
            $table->integer('quantity')->default(0);
            
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade'); // Must reference 'lists'
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
