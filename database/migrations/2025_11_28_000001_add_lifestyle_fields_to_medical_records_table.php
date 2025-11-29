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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('smoking_status', 20)->nullable()->after('creation_date');
            $table->string('alcohol_use', 20)->nullable()->after('smoking_status');
            $table->string('physical_activity', 20)->nullable()->after('alcohol_use');
            $table->text('special_needs')->nullable()->after('physical_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['smoking_status', 'alcohol_use', 'physical_activity', 'special_needs']);
        });
    }
};

