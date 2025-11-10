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
        Schema::create('treatments_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_record');
            $table->foreign('id_record')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->unsignedBigInteger('treatment_id');
            $table->foreign('treatment_id')
                ->references('id')
                ->on('treatments');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['En seguimiento', 'Completado', 'suspendido'])->default('En seguimiento');
            $table->unsignedBigInteger('prescribed_by')->nullable();
            $table->foreign('prescribed_by')
                ->references('id')
                ->on('medic_users')
                ->onDelete('set null');
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')
                ->references('id')
                ->on('appointments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_records');
    }
};
