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
        Schema::table('user_data', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('type_user')->nullable()->change();
            $table->foreign('type_user')
                    ->references('id')
                    ->on('type_users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_data', function (Blueprint $table) {
            //
            $table->dropForeign(['type_user']);
            $table->dropColumn('type_user');
        });
    }
};
