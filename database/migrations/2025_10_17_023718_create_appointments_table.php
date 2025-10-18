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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')
                ->on('patient_users');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('medic_users');
            $table->unsignedBigInteger('receptionist_id')->nullable();
            $table->foreign('receptionist_id')
                ->references('id')
                ->on('recepcionist_users');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
            $table->string('reason')->nullable();
            $table->string('notes')->nullable();
            $table->string('notifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
