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
        Schema::create('cleaning_reports', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('agent_id');
            $blueprint->string('location_id')->nullable(); // On utilise string car GLPI IDs peuvent être complexes ou on veut garder le nom
            $blueprint->string('type'); // offices, mortuary, rooms, autolaveuse
            $blueprint->json('data')->nullable(); // Contiendra les champs spécifiques plus tard
            $blueprint->timestamps();

            $blueprint->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_reports');
    }
};
