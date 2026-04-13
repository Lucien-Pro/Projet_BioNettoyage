<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // On précise le nom exact de la table GLPI
    protected $table = 'glpi_locations';

    // Désactiver les timestamps car la table GLPI ne suit pas la convention Laravel (created_at/updated_at)
    // Elle utilise date_creation et date_mod
    public $timestamps = false;

    protected $fillable = [
        'name',
        'completename',
        'comment',
        'level',
        'building',
        'room',
        'address',
        'postcode',
        'town'
    ];

    /**
     * Obtenir les sous-lieux (ex: les salles d'un bâtiment)
     */
    public function children()
    {
        return $this->hasMany(Location::class, 'locations_id');
    }

    /**
     * Obtenir le lieu parent (ex: le bâtiment d'une salle)
     */
    public function parent()
    {
        return $this->belongsTo(Location::class, 'locations_id');
    }

    /**
     * Les agents assignés à ce local.
     */
    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_location', 'location_id', 'agent_id')
                    ->withTimestamps();
    }
}
