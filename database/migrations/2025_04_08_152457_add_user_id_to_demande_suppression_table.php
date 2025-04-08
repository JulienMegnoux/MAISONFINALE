<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('demande_suppression', function (Blueprint $table) {
            if (!Schema::hasColumn('demande_suppression', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                // Tu peux ajouter la contrainte si tu veux :
                // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('demande_suppression', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
