<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Location;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    /**
     * Affiche la grille de planning hebdomadaire.
     */
    public function index()
    {
        $agents = Agent::with(['plannings.location', 'user'])->orderBy('nom')->get();
        
        $buildings = Location::where('locations_id', 0)
            ->with(['children' => function($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $startOfWeek = now()->startOfWeek();
        $days = [];
        for ($i = 1; $i <= 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i - 1);
            $days[$i] = [
                'label' => $date->translatedFormat('l'),
                'date' => $date->translatedFormat('d F'),
                'full_date' => $date->toDateString(),
            ];
        }

        return view('planning.index', compact('agents', 'buildings', 'days'));
    }

    /**
     * Enregistre une nouvelle affectation dans le planning.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'location_id' => 'required|exists:glpi_locations,id',
            'day_of_week' => 'required|integer|between:1,7',
        ]);

        // Vérifier si cette affectation existe déjà pour éviter les doublons
        $exists = Planning::where($validated)->exists();

        if (!$exists) {
            Planning::create($validated);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Déjà planifié']);
    }

    /**
     * Supprime une affectation du planning.
     */
    public function destroy(Planning $planning)
    {
        $planning->delete();
        return back()->with('success', 'Entrée supprimée du planning');
    }

    /**
     * Version AJAX pour la suppression (pour une UI plus fluide)
     */
    public function removeAjax(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'location_id' => 'required|exists:glpi_locations,id',
            'day_of_week' => 'required|integer|between:1,7',
        ]);

        Planning::where($validated)->delete();

        return response()->json(['success' => true]);
    }
}
