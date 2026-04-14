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
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Les entrées de planning de l'agent.
     */
    public function plannings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Planning::class);
    }

    /**
     * Les tâches prévues pour aujourd'hui.
     */
    public function todayPlannings()
    {
        // ISO-8601 numeric representation of the day of the week (1 for Monday through 7 for Sunday)
        $dayOfWeek = now()->format('N');
        return $this->hasMany(Planning::class)->where('day_of_week', $dayOfWeek);
    }

    /**
     * Les lieux associés à l'agent.
     */
    public function locations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'agent_location');
    }
}
