<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('shoppinglist_id')->constrained()->onDelete('cascade'); // Foreign key with cascade delete
            $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade'); // Add recipient_id foreign key
            $table->string('email'); // Email of the invited user
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
