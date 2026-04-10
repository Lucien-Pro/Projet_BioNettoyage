<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role !== 'super_admin' && $request->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        // On récupère uniquement les lieux racines (les bâtiments) avec leurs enfants
        $locations = Location::with('children')
            ->where('locations_id', 0)
            ->orderBy('name')
            ->get();

        return view('locations.index', compact('locations'));
    }
}
