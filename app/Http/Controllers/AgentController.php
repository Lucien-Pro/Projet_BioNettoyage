<?php

namespace App\Http\Controllers;

use App\Models\Agent;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Les agents sont récupérés depuis la base de données locale
        // après avoir été synchronisés via php artisan ldap:sync-agents
        $agents = Agent::with(['user'])->orderBy('nom')->get();
        
        return view('agents.index', compact('agents'));
    }
}
