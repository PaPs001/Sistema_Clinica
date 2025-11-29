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
        Schema::table('consult_disease', function (Blueprint $table) {
            $table->text('prescribed_medications')->nullable()->after('treatment_diagnosis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_disease', function (Blueprint $table) {
            $table->dropColumn('prescribed_medications');
        });
    }
};

