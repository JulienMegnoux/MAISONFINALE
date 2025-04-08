<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('demande_suppression', function (Blueprint $table) {
            // Ajoute la colonne si elle n'existe pas déjà (par précaution)
            if (!Schema::hasColumn('demande_suppression', 'objet_connecte_id')) {
                $table->unsignedBigInteger('objet_connecte_id')->nullable();

                // Tu peux ajouter la contrainte si tu veux
                // $table->foreign('objet_connecte_id')->references('id')->on('objets_connectes')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('demande_suppression', function (Blueprint $table) {
            $table->dropColumn('objet_connecte_id');
        });
    }
};
