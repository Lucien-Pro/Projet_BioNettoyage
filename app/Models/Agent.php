<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'initiales',
        'email',
        'statut',
        'user_id'
    ];

    /**
     * Le compte utilisateur lié.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Les locaux assignés à cet agent.
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'agent_location', 'agent_id', 'location_id')
                    ->withTimestamps();
    }
}
