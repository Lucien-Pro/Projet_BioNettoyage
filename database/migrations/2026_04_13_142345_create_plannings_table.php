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
        // Supprime l'ancienne table pivot si elle existe
        Schema::dropIfExists('agent_location');

        // Crée la nouvelle table de planning hebdomadaire
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('location_id');
            $table->foreign('location_id')->references('id')->on('glpi_locations')->onDelete('cascade');
            $table->unsignedTinyInteger('day_of_week'); // 1 = Lundi, 7 = Dimanche
            $table->timestamps();

            // Index pour accélérer les recherches par jour et agent
            $table->index(['agent_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};
