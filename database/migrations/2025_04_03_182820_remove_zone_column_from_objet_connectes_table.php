<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            $table->dropColumn('zone'); // on supprime la colonne texte "zone"
        });
    }

    public function down()
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            $table->string('zone')->nullable(); // pour rollback
        });
    }
};

