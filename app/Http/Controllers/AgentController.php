<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::with(['user', 'locations'])->orderBy('nom')->get();
        // Récupérer les bâtiments avec leurs salles pour le modal d'affectation
        $buildings = Location::where('locations_id', 0)
            ->with(['children' => function($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        return view('agents.index', compact('agents', 'buildings'));
    }

    /**
     * Mettre à jour les affectations de zones pour un agent.
     */
    public function updateAssignments(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'locations' => 'nullable|array',
            'locations.*' => 'exists:glpi_locations,id'
        ]);

        $agent->locations()->sync($validated['locations'] ?? []);

        return redirect()->route('agents.index')->with('success', 'Affectations mises à jour pour ' . $agent->prenom . ' ' . $agent->nom);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'initiales' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:users,email',
            'statut' => 'required|string|in:actif,inactif',
            'password' => 'required|string|min:8',
        ];

        if ($request->user()->role === 'super_admin') {
            $rules['role'] = 'nullable|string|in:admin,utilisateur';
        }

        $validated = $request->validate($rules);

        $finalRole = 'utilisateur';
        if ($request->user()->role === 'super_admin' && !empty($validated['role'])) {
            $finalRole = $validated['role'];
        }

        return DB::transaction(function () use ($validated, $finalRole) {
            $user = User::create([
                'name' => $validated['prenom'] . ' ' . $validated['nom'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'must_change_password' => true,
                'role' => $finalRole,
            ]);

            $agentData = $validated;
            unset($agentData['password'], $agentData['role']);
            $agentData['user_id'] = $user->id;

            Agent::create($agentData);

            return redirect()->route('agents.index')->with('success', 'Agent et compte utilisateur créés avec succès.');
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agent $agent)
    {
        $rules = [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'initiales' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:users,email,' . ($agent->user_id ?? 0),
            'statut' => 'required|string|in:actif,inactif',
        ];

        if ($request->user()->role === 'super_admin') {
            $rules['role'] = 'required|string|in:admin,utilisateur';
        }

        $validated = $request->validate($rules);

        return DB::transaction(function () use ($validated, $agent, $request) {
            // Mise à jour de l'agent
            $agent->update([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'initiales' => $validated['initiales'],
                'email' => $validated['email'],
                'statut' => $validated['statut'],
            ]);

            // Mise à jour de l'utilisateur lié
            if ($agent->user) {
                $userData = [
                    'name' => $validated['prenom'] . ' ' . $validated['nom'],
                    'email' => $validated['email'],
                ];

                if ($request->user()->role === 'super_admin' && !empty($validated['role'])) {
                    $userData['role'] = $validated['role'];
                }

                $agent->user->update($userData);
            }

            return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        return DB::transaction(function () use ($agent) {
            if ($agent->user) {
                $agent->user->delete();
            }
            $agent->delete();
        });

        return redirect()->route('agents.index')->with('success', 'Agent et compte utilisateur supprimés avec succès');
    }
}
