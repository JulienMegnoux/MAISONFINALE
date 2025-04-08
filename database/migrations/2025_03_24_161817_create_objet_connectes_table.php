<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetConnectesTable extends Migration
{
    public function up()
    {
        Schema::create('objet_connectes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_objet_id')->constrained('types_objets');
            $table->string('nom');
            $table->string('type');
            $table->string('zone')->nullable();
            $table->string('etat'); // actif/inactif
            $table->integer('luminosite')->nullable();        // Pour une lampe
            $table->float('temperature_actuelle')->nullable();
            $table->float('temperature_cible')->nullable();
            $table->string('connectivite')->nullable();          // Ancienne colonne, à garder si nécessaire
            $table->integer('batterie')->nullable();             // en %
            $table->integer('volume')->nullable();               // Pour alarme, en pourcentage par exemple
            $table->integer('position')->nullable();             // Pour volets
            // Champs spécifiques pour les nouveaux types d'objets
            $table->string('resolution')->nullable();            // Pour caméra de surveillance
            $table->string('champ_vision')->nullable();          // Pour caméra de surveillance
            $table->float('puissance')->nullable();              // Pour aspirateur robot
            $table->string('connectivite_s')->nullable();          // Pour serrure connectée
            $table->float('qualite_air')->nullable();            // Pour capteur de qualité de l'air
            $table->string('interphone')->nullable();            // Pour interphone connecté
            $table->string('etat_portail')->nullable();          // Pour portail
            $table->timestamp('derniere_interaction')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('objet_connectes');
    }
}
