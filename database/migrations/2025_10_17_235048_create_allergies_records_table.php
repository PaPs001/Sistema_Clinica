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
        Schema::create('allergies_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_record');
            $table->foreign('id_record')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->unsignedBigInteger('allergie_id');
            $table->foreign('allergie_id')
                ->references('id')
                ->on('allergies');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergies_records');
    }
};
