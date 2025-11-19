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
        Schema::create('patient_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->nullable();
            //nuevo campo
            $table->string('DNI');
            $table->boolean('is_Temporary')->default(false);
            $table->string('temporary_name')->nullable();
            $table->string('temporary_phone')->nullable();
            $table->string('userCode');
            $table->foreign('userId')
                ->references('id')
                ->on('general_users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_users');
    }
};
