<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommandeAchatController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\MissionVehiculeController;
use App\Http\Controllers\CarburantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Achats
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('commandes', CommandeAchatController::class);
    Route::patch('/commandes/{commande}/statut', [CommandeAchatController::class, 'updateStatut'])->name('commandes.statut');

    // Stocks
    Route::resource('articles', ArticleController::class);
    Route::resource('mouvements', MouvementStockController::class)->only(['index', 'create', 'store', 'show']);

    // Équipements
    Route::resource('equipements', EquipementController::class);

    // Parc automobile
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('missions', MissionVehiculeController::class);
    Route::patch('/missions/{mission}/statut', [MissionVehiculeController::class, 'updateStatut'])->name('missions.statut');
    Route::resource('carburant', CarburantController::class)->except(['edit', 'update']);

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Administration
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
