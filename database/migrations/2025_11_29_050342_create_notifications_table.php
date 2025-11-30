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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id');
            $table->string('user_role'); // 'medico', 'recepcionista', 'paciente'
            $table->string('title');
            $table->text('message');
            $table->string('status')->default('pending'); // 'pending', 'read'
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('general_users')->onDelete('set null');
            $table->foreign('receiver_id')->references('id')->on('general_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
