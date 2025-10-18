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
        Schema::create('disease_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_record');
            $table->foreign('id_record')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->unsignedBigInteger('disease_id');
            $table->foreign('disease_id')
                ->references('id')
                ->on('disease');
            $table->date('diagnosis_date');
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
