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
        Schema::create('general_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->unsignedBigInteger('typeUser_id')->nullable();
            $table->foreign('typeUser_id')
                ->references('id')
                ->on('Acces_roles')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_users');
    }
};
