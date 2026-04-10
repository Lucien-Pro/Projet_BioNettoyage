<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('agents', AgentController::class);

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
