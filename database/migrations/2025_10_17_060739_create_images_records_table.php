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
        Schema::create('images_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_records');
            $table->foreign('id_records')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade');
            $table->string('file_name');
            $table->string('route');
            $table->string('format');
            $table->float('file_size');
            $table->text('description');
            $table->timestamp('upload_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images_records');
    }
};
