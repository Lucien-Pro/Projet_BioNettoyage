<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|email|max:255|unique:users,email',
            'statut' => 'required|string|in:actif,inactif',
            'password' => 'required|string|min:8',
        ]);

        // 1. Créer le compte utilisateur
        $user = User::create([
            'name' => $validated['prenom'] . ' ' . $validated['nom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'must_change_password' => true,
            'role' => 'utilisateur',
        ]);

        // 2. Créer l'agent lié
        $agentData = $validated;
        unset($agentData['password']);
        $agentData['user_id'] = $user->id;

        Agent::create($agentData);

        return redirect()->route('agents.index')->with('success', 'Agent et compte utilisateur créés avec succès. Le mot de passe devra être changé à la première connexion.');
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
