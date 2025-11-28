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
        //
        schema::create('consult_disease', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medical_record');
            $table->foreign('id_medical_record')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')
                ->references('id')
                ->on('appointments');
            $table->text('reason');
            $table->text('symptoms');
            $table->text('findings');
            $table->unsignedBigInteger('diagnosis_id');
            $table->foreign('diagnosis_id')
                ->references('id')
                ->on('chronics_diseases');
            $table->text('treatment_diagnosis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
