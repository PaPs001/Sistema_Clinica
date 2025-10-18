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
        Schema::create('nurse_users', function (Blueprint $table) {
            $table->id();
            $table->enum('turno', ['matutino', 'vespertino', 'nocturno']);
            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')
                ->references('id')
                ->on('general_users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_users');
    }
};
