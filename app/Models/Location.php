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
}
