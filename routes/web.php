<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanningController;
use App\Models\Agent;
use App\Models\Location;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $agents_count = Agent::count();
    $locations_count = Location::count();
    $agents = Agent::with(['user', 'plannings.location'])->get();
    
    return view('dashboard', compact('agents_count', 'locations_count', 'agents'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('agents', [AgentController::class, 'index'])->name('agents.index');
    
    // Planning Hebdomadaire
    Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');
    Route::post('/planning', [PlanningController::class, 'store'])->name('planning.store');
    Route::delete('/planning/ajax-remove', [PlanningController::class, 'removeAjax'])->name('planning.ajax-remove');
    Route::delete('/planning/{planning}', [PlanningController::class, 'destroy'])->name('planning.destroy');

    Route::get('/locaux', [LocationController::class, 'index'])->name('locations.index');

    // Forced password change
    Route::get('/force-password-change', function () {
        return view('auth.force-password-change');
    })->name('password.force-change');

    Route::post('/force-password-change', function (Illuminate\Http\Request $request) {
        $request->validate([
            'password' => ['required', 'confirmed', Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Mot de passe mis à jour avec succès.');
    })->name('password.force-change.update');
});

require __DIR__.'/auth.php';
