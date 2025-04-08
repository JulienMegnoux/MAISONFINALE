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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'date_naissance')) {
                $table->date('date_naissance')->nullable();
            }
            if (!Schema::hasColumn('users', 'genre')) {
                $table->string('genre')->nullable();
            }
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable(); // nom ou chemin d’image
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'date_naissance')) {
                $table->dropColumn('date_naissance');
            }
            if (Schema::hasColumn('users', 'genre')) {
                $table->dropColumn('genre');
            }
            if (Schema::hasColumn('users', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('users', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
