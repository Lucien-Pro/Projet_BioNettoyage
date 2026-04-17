<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'location_id',
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'agent_id' => 'integer',
    ];

    /**
     * L'agent qui a rempli le rapport.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Le lieu concerné (lié à GLPI via son ID).
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
