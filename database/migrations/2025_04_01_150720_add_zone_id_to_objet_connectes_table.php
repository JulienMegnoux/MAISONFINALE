<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (!Schema::hasColumn('objet_connectes', 'zone_id')) {
                $table->foreignId('zone_id')->nullable()->constrained('zones');
            }
        });
    }

    public function down(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
            $table->dropColumn('zone_id');
        });
    }
};
