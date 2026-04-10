<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::orderBy('nom')->get();
        return view('agents.index', compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'initiales' => 'required|string|max:10',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|string|in:actif,inactif',
        ]);

        Agent::create($validated);

        return redirect()->route('agents.index')->with('success', 'Agent ajouté avec succès');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'initiales' => 'required|string|max:10',
            'email' => 'nullable|email|max:255',
            'statut' => 'required|string|in:actif,inactif',
        ]);

        $agent->update($validated);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent supprimé avec succès');
    }
}
