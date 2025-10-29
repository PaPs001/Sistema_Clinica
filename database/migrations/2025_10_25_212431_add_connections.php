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
        schema::table('disease_records', function (Blueprint $table) {
            $table->foreign('disease_id')
                ->references('id')
                ->on('disease');        
        });
        schema::table('allergies_records', function (Blueprint $table) {
            $table->foreign('allergie_id')
                ->references('id')
                ->on('allergies');      
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
