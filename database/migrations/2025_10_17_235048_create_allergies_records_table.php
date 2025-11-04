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
                //nuevo campo
            $table->unsignedBigInteger('alergeno_id');
            $table->foreign('alergeno_id')
                ->references('id')
                ->on('allergenes');
                //nuevos campos
            $table->enum('severity', ['Leve', 'Moderada', 'Grave']);
            $table->enum('status', ['Activa', 'Inactiva']);
            $table->text('symptoms');
            $table->text('treatments');
            $table->date('diagnosis_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /* -TipoAlergia(enum)
-id_alergeno-> id(alergeno)(int)
-Severidad(enum)
-Estado(enum)
-fecha_diagnostico(DATE)
-Sintomas(TEXT)
-tratamientos(TEXT)
-obvservaciones(TEXT) */ 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergies_records');
    }
};
