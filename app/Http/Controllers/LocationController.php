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

        $locations = Location::orderBy('completename')->paginate(20);
        return view('locations.index', compact('locations'));
    }
}
