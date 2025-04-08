<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (!Schema::hasColumn('objet_connectes', 'position')) {
                $table->integer('position')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (Schema::hasColumn('objet_connectes', 'position')) {
                $table->dropColumn('position');
            }
        });
    }
};

