<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (!Schema::hasColumn('objet_connectes', 'heure_debut')) {
                $table->time('heure_debut')->nullable()->after('luminosite');
            }
            if (!Schema::hasColumn('objet_connectes', 'heure_fin')) {
                $table->time('heure_fin')->nullable()->after('heure_debut');
            }
            // NE PAS recréer etat_portail s'il est déjà présent
            if (!Schema::hasColumn('objet_connectes', 'etat_portail')) {
                $table->string('etat_portail')->nullable()->after('etat');
            }
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            $table->dropColumn(['heure_debut', 'heure_fin', 'etat_portail']);
        });
    }
    
    
};
