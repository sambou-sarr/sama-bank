<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\CompteBancaire;
use App\Notifications\OperationEffectuee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OperationController extends Controller
{
     private function verifierCompteValide($compte)
    {
        if ($compte->statut !== 'valider') {
            return redirect()->back()->withErrors([
                'statut' => 'Ce compte n’est pas encore validé. Aucune opération n’est autorisée.'
            ]);
        }
        return true; 
    }


    public function index($id)
    { 
        $comptes = CompteBancaire::where('user_id', $id)->get();
       return view("user.mes_compte",compact('comptes'));
    }
    
    public function show($id)
    {
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.espace_compte', compact('compte'));
    }

    public function afficherFormulaireTransfert($id)
    {
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }
        $validation = $this->verifierCompteValide($compte);
        if ($validation !== true) {
            return $validation; 
        }

        return view('user.transfert', compact('compte'));
    }
   

    public function afficherFormulaireDepot($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        
        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }
        $validation = $this->verifierCompteValide($compte);
        if ($validation !== true) {
            return $validation; 
        }

        return view('user.depot', compact('compte'));
    }

  
    public function executerDepot(Request $request, $id)
{
    $compte = CompteBancaire::findOrFail($id);

    if ((int)$compte->user_id !== Auth::id()) {
        abort(403);
    }

    $validation = $this->verifierCompteValide($compte);
    if ($validation !== true) {
        return $validation;
    }

    $request->validate([
        'montant' => ['required', 'numeric', 'min:1'],
    ]);

    DB::beginTransaction();

    try {
        $compte->solde += $request->montant;
        $compte->save();

        $transaction = new Transaction();
        $transaction->type_operation = 'depot';
        $transaction->montant = $request->montant;
        $transaction->date = Carbon::now();
        $transaction->compte_source_id = $compte->id;
        $transaction->compte_dest_id = null;
        $transaction->save();

        $user = $compte->user; 
        if ($user) {
            $user->notify(new OperationEffectuee('dépôt', $request->montant));
        }

        DB::commit();

        return redirect()->route('compte.details', $compte->id)->with('success', 'Dépôt effectué avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();

        return back()->withErrors(['error' => 'Une erreur est survenue pendant le dépôt.']);
    }
}


    public function afficherFormulaireRetrait($id)
    {
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }
        $validation = $this->verifierCompteValide($compte);
        if ($validation !== true) {
            return $validation; 
        }

        return view('user.retrait', compact('compte'));
    }


 public function executerRetrait(Request $request, $id)
{
    $compte = CompteBancaire::findOrFail($id);

    if ((int) $compte->user_id !== Auth::id()) {
        abort(403);
    }

    $validation = $this->verifierCompteValide($compte);
    if ($validation !== true) {
        return $validation; 
    }

    // Validation du montant
    $request->validate([
        'montant' => ['required', 'numeric', 'min:1'],
    ]);

    // Limite des retraits pour comptes épargne
    if ($compte->type_compte == "epargne") {
        $retraitsCeMois = Transaction::where('compte_source_id', $compte->id)
            ->where('type_operation', 'retrait')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        if ($retraitsCeMois >= 3) {
            return back()->withErrors(['error' => 'Vous avez déjà effectué 3 retraits ce mois-ci pour ce compte épargne.']);
        }
    }

    // Vérifie si le solde est suffisant
    if ($compte->solde < $request->montant) {
        return back()->withErrors(['error' => 'Solde insuffisant pour effectuer ce retrait.']);
    }

    DB::beginTransaction();

    try {
        // Mise à jour du solde
        $compte->solde -= $request->montant;
        $compte->save();

        // Enregistrement dans l’historique des transactions
        $transaction = new Transaction();
        $transaction->type_operation = 'retrait';
        $transaction->montant = $request->montant;
        $transaction->date = Carbon::now();
        $transaction->compte_source_id = $compte->id;
        $transaction->compte_dest_id = null;
        $transaction->save();

        // Envoie notification
        $user = $compte->user; // Correction ici
        $user->notify(new OperationEffectuee('retrait', $request->montant));

        DB::commit();

        return redirect()->route('compte.details', $compte->id)->with('success', 'Retrait effectué avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Une erreur est survenue pendant le retrait.']);
    }
}


}
