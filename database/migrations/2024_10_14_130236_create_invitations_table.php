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
    Schema::create('invitations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('shoppinglist_id')->constrained('lists')->onDelete('cascade');
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
