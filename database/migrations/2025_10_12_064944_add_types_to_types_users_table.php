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
        Schema::table('type_users', function (Blueprint $table) {
            //
            DB::table('type_users')->insert([
                ['type' => 'admin'],
                ['type' => 'medico'],
                ['type' => 'paciente'],
                ['type' => 'recepcionista'],
                ['type' => 'enfermera'],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_users', function (Blueprint $table) {
            //
            DB::table('type_users')->whereIn('type', ['admin', 'medico', 'paciente', 'recepcionista', 'enfermera'])->delete();
        });
    }
};
