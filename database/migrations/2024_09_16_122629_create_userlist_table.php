<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('list_id')->constrained('shoppinglists')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'list_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_lists');
    }
};
