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
        Schema::create('consult_disease_medication', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consult_disease_id');
            $table->unsignedBigInteger('medication_id');
            $table->timestamps();

            $table->foreign('consult_disease_id')
                ->references('id')
                ->on('consult_disease')
                ->onDelete('cascade');

            $table->foreign('medication_id')
                ->references('id')
                ->on('medications')
                ->onDelete('cascade');

            $table->unique(
                ['consult_disease_id', 'medication_id'],
                'cd_medication_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_disease_medication');
    }
};
