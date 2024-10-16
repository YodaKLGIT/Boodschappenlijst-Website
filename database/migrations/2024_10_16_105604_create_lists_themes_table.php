<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lists_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['list_id', 'theme_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lists_themes');
    }
};