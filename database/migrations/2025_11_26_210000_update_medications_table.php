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
        Schema::table('medications', function (Blueprint $table) {
            // Solo agrega las columnas si faltan en la tabla actual
            if (!Schema::hasColumn('medications', 'name')) {
                $table->string('name');
            }

            if (!Schema::hasColumn('medications', 'category')) {
                $table->string('category');
            }

            if (!Schema::hasColumn('medications', 'presentation')) {
                $table->string('presentation');
            }

            if (!Schema::hasColumn('medications', 'concentration')) {
                $table->string('concentration');
            }

            if (!Schema::hasColumn('medications', 'stock')) {
                $table->integer('stock');
            }

            if (!Schema::hasColumn('medications', 'min_stock')) {
                $table->integer('min_stock');
            }

            if (!Schema::hasColumn('medications', 'expiration_date')) {
                $table->date('expiration_date');
            }

            if (!Schema::hasColumn('medications', 'batch_number')) {
                $table->string('batch_number')->nullable();
            }

            if (!Schema::hasColumn('medications', 'provider')) {
                $table->string('provider')->nullable();
            }

            if (!Schema::hasColumn('medications', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            // Elimina solo si existe para no fallar en entornos inconsistentes
            foreach ([
                'name',
                'category',
                'presentation',
                'concentration',
                'stock',
                'min_stock',
                'expiration_date',
                'batch_number',
                'provider',
                'status',
            ] as $column) {
                if (Schema::hasColumn('medications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
