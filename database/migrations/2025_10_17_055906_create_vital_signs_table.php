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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_record_id')->nullable();
            $table->foreign('medical_record_id')
                ->references('id')
                ->on('medical_records');
            
                $table->unsignedBigInteger('register_date');
            $table->foreign('register_date')
                ->references('id')
                ->on('appointments');
            
            $table->float('temperature')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->unsignedBigInteger('register_by');
            $table->foreign('register_by')
                ->references('id')
                ->on('nurse_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
