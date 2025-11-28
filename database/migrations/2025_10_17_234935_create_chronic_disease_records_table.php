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
        Schema::create('chronic_disease_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_record')->nullable();
            $table->foreign('id_record')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->unsignedBigInteger('chronics_diseases_id')->nullable();
            $table->foreign('chronics_diseases_id')
                ->references('id')
                ->on('chronics_diseases');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_records');
    }
};
