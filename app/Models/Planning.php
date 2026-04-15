<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planning extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'location_id',
        'day_of_week',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'agent_id' => 'integer',
        'location_id' => 'integer',
    ];

    /**
     * L'agent à qui appartient cette entrée de planning.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Le lieu (pièce/bâtiment) concerné par cette entrée.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Retourne le nom du jour en français.
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche',
        ];

        return $days[$this->day_of_week] ?? 'Inconnu';
    }
}
