<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAccountMail;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::with(['user'])->orderBy('nom')->get();
        return view('agents.index', compact('agents'));
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

        return DB::transaction(function () use ($validated, $finalRole, $request) {
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

            try {
                Mail::to($user->email)->send(new NewAccountMail($user, $validated['password']));
                $successMessage = 'Agent et compte utilisateur créés avec succès. Un e-mail a été envoyé.';
            } catch (\Exception $e) {
                $successMessage = 'Agent créé avec succès, mais l\'e-mail n\'a pas pu être envoyé : ' . $e->getMessage();
            }

            return redirect()->route('agents.index')->with('success', $successMessage);
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

    public function destroy(Agent $agent)
    {
        DB::transaction(function () use ($agent) {
            if ($agent->user) {
                $agent->user->delete();
            }
            $agent->delete();
        });

        return redirect()->route('agents.index')->with('success', 'Agent et compte utilisateur supprimés avec succès');
    }
}
