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
        Schema::create('allergies_allergenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allergie_id')->nullable();
            $table->foreign('allergie_id')
                ->references('id')
                ->on('allergies')
                ->onDelete('cascade');
            $table->unsignedBigInteger('allergene_id')->nullable();
            $table->foreign('allergene_id')
                ->references('id')
                ->on('allergenes')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergies_allergenes');
    }
};
