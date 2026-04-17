<?php

namespace App\Http\Controllers;

use App\Models\CleaningReport;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CleaningReportController extends Controller
{
    /**
     * Affiche l'écran de sélection du type de tâche.
     */
    public function index()
    {
        $types = [
            'offices' => 'Enregistrement de l\'entretien des offices',
            'mortuary' => 'Traçabilité de l\'entretien de la chambre mortuaire',
            'rooms' => 'Traçabilité de l\'entretien des chambres',
            'autolaveuse' => 'Suivi plan de nettoyage-désinfection quotidien AUTO LAVEUSE',
        ];

        return view('cleaning.index', compact('types'));
    }

    /**
     * Affiche le formulaire spécifique pour un type de tâche.
     */
    public function create(string $type)
    {
        $validTypes = ['offices', 'mortuary', 'rooms', 'autolaveuse'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $titles = [
            'offices' => 'Entretien des offices',
            'mortuary' => 'Entretien chambre mortuaire',
            'rooms' => 'Entretien des chambres',
            'autolaveuse' => 'Suivi AUTO LAVEUSE',
        ];

        $title = $titles[$type];
        
        // On récupère les lieux pour le formulaire (peut être filtré par le planning de l'agent)
        $agent = Auth::user()->agent;
        $locations = $agent ? $agent->plannings()->with('location')->get()->pluck('location') : collect();

        return view('cleaning.create', compact('type', 'title', 'locations'));
    }

    /**
     * Enregistre le rapport.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'location_id' => 'nullable|string',
        ]);

        $agent = Auth::user()->agent;

        if (!$agent) {
            return back()->with('error', 'Vous devez être enregistré comme agent pour faire cela.');
        }

        CleaningReport::create([
            'agent_id' => $agent->id,
            'location_id' => $request->location_id,
            'type' => $request->type,
            'data' => $request->except(['_token', 'type', 'location_id']), // On stocke tout le reste en JSON
        ]);

        return redirect()->route('dashboard')->with('success', 'Rapport de nettoyage enregistré avec succès.');
    }
}
