<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (!Schema::hasColumn('objet_connectes', 'volume')) {
                $table->integer('volume')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('objet_connectes', function (Blueprint $table) {
            if (Schema::hasColumn('objet_connectes', 'volume')) {
                $table->dropColumn('volume');
            }
        });
    }
};
