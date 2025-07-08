<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;


use Illuminate\Support\Facades\Artisan;

Route::get('/refresh-migrations', function () {
    Artisan::call('migrate:refresh');
    return 'Migrations rafraîchies';
});

// Page d'accueil publique
Route::get('/', function () {
    return view('user.index');
});
// Routes pour utilisateurs authentifiés (profil)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour administrateurs (auth + vérifié)
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/demande', [AdminController::class, 'demande'])->name('demande');
    Route::get('/detail/demande/{id}', [AdminController::class, 'detail_demande'])->name('detail.demande');
    Route::post('/demande/{id}/valider', [AdminController::class, 'valider'])->name('demande.valider');
    Route::post('/demande/{id}/rejeter', [AdminController::class, 'rejeter'])->name('demande.rejeter');
    Route::put('/demande/{id}/action', [AdminController::class, 'traiterAction'])->name('demande.action');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
});

// Routes pour utilisateurs authentifiés (espace client)
Route::middleware('auth')->group(function () {
    // Dashboard utilisateur
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Gestion demandes ouverture/clôture compte
    Route::get('/demande/compte', [DemandeController::class, 'index'])->name('form.demande');
    Route::post('/demande/store', [DemandeController::class, 'store'])->name('create.demande');
    Route::get('/compte/{id}/cloture', [DemandeController::class, 'cloture'])->name('demande.cloture');

    // Liste des comptes utilisateur
    Route::get('/user/compte', [OperationController::class, 'index'])->name('liste_compte');

    // Carte bancaire PDF
    Route::get('/compte/{id}/carte/pdf', [CarteController::class, 'download'])->name('carte.pdf');
    Route::get('/compte/{id}/carte', [CarteController::class, 'index'])->name('compte.carte');

    // Formulaire opérations sur compte (exemple)
    Route::get('/compte/{id}/operation', [OperationController::class, 'form'])->name('operations.form');

    // PDF des transactions 
    Route::get('/compte/{id}/transactions/pdf', [TransactionController::class, 'pdf'])->name('transactions.pdf');
    Route::get('/compte/{id}/historique', [TransactionController::class, 'index'])->name('transactions.historique');

    // Détails compte
    Route::get('/compte/{id}', [OperationController::class, 'show'])->name('compte.details');

    // Transfert d'argent
    Route::get('/compte/{id}/transfert', [OperationController::class, 'afficherFormulaireTransfert'])->name('compte.transfert.formulaire');
    Route::post('/compte/{id}/transfert', [TransactionController::class, 'executerTransfert'])->name('compte.transfert.executer');


    // Historique des opérations
    Route::get('/compte/{id}/historique', [TransactionController::class, 'historique'])->name('compte.historique');
    Route::get('/mes-transactions', [TransactionController::class, 'mesTransactions'])->name('compte.transaction');


    // Dépôt
    Route::get('/compte/{id}/depot', [OperationController::class, 'afficherFormulaireDepot'])->name('compte.depot.formulaire');
    Route::post('/compte/{id}/depot', [OperationController::class, 'executerDepot'])->name('compte.depot.executer');

    // Retrait
    Route::get('/compte/{id}/retrait', [OperationController::class, 'afficherFormulaireRetrait'])->name('compte.retrait.formulaire');
    Route::post('/compte/{id}/retrait', [OperationController::class, 'executerRetrait'])->name('compte.retrait.executer');
});

// Import des routes d'authentification Laravel Breeze / Jetstream etc.
require __DIR__.'/auth.php';
