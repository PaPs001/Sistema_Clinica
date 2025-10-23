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
        Schema::table('acces_roles', function (Blueprint $table) {
            //
            $table->enum('name_type', ['admin', 'medic', 'patient', 'nurse', 'recep'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acces_roles', function (Blueprint $table) {
            //
            $table->string('name_type')->change();
        });
    }
};
