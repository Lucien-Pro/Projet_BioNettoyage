<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Agent;
use App\Models\Planning;
use App\Models\Location;

echo "--- Diagnostic Données ---\n";
echo "Agents: " . Agent::count() . "\n";
echo "Plannings: " . Planning::count() . "\n";
echo "Locations: " . Location::count() . "\n";

$agents = Agent::with('plannings')->get();
foreach ($agents as $agent) {
    echo "Agent: {$agent->prenom} {$agent->nom} (Plannings: " . $agent->plannings->count() . ")\n";
    foreach ($agent->plannings as $p) {
        $locName = $p->location ? $p->location->name : 'N/A';
        echo "  - Jour {$p->day_of_week}: {$locName}\n";
    }
}
