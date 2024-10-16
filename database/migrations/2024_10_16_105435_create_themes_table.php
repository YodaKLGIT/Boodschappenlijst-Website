<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('strap_color')->default('bg-black-800');
            $table->string('body_color')->default('bg-pink-100');
            $table->string('content_bg_color')->default('bg-white'); 
            $table->string('hover_color')->default('bg-pink-200');
            $table->string('count_circle_color')->default('bg-gray-800');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

