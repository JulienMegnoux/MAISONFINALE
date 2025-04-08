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
        Schema::create('historiques_objets', function (Blueprint $table) {

        $table->id();
        $table->foreignId('objet_connecte_id')->constrained('objet_connectes')->onDelete('cascade');
        $table->string('type_parametre');
        $table->float('valeur')->nullable();
        $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiques_objets');
    }
};
