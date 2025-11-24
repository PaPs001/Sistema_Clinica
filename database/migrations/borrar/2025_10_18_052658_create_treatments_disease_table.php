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
        Schema::create('treatments_disease', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treatment_id');
            $table->foreign('treatment_id')
                ->references('id')
                ->on('treatments');
            $table->unsignedBigInteger('disease_id');
            $table->foreign('disease_id')
                ->references('id')
                ->on('disease');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_disease');
    }
};
