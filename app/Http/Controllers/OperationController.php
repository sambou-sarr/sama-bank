<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\CompteBancaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comptes = CompteBancaire::all();
       return view("user.mes_compte",compact('comptes'));
    }
    
    public function show($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        // Tu peux vérifier que le compte appartient bien à l'utilisateur connecté ici

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.espace_compte', compact('compte'));
    }

    // Afficher le formulaire de transfert
    public function afficherFormulaireTransfert($id)
    {
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.transfert', compact('compte'));
    }
   

    // Afficher formulaire dépôt
    public function afficherFormulaireDepot($id)
    {
        
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.depot', compact('compte'));
    }

    // Exécuter dépôt
  
public function executerDepot(Request $request, $id)
{
    $compte = CompteBancaire::findOrFail($id);

    if ((int)$compte->user_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'montant' => ['required', 'numeric', 'min:1'],
    ]);

    DB::beginTransaction();

    try {
        // Mise à jour du solde
        $compte->solde += $request->montant;
        $compte->save();

        // Enregistrement dans l’historique des transactions
        $transaction = new Transaction();
        $transaction->type_operation = 'depot';
        $transaction->montant = $request->montant;
        $transaction->date = Carbon::now();
        $transaction->compte_source_id = $compte->id;
        $transaction->compte_dest_id = null; // aucun destinataire pour un dépôt
        $transaction->save();

        DB::commit();

        return redirect()->route('compte.details', $compte->id)->with('success', 'Dépôt effectué avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Une erreur est survenue pendant le dépôt.']);
    }
}

    // Afficher formulaire retrait
    public function afficherFormulaireRetrait($id)
    {
        $compte = CompteBancaire::findOrFail($id);

        if ((int)$compte->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.retrait', compact('compte'));
    }

    // Exécuter retrait

    public function executerRetrait(Request $request, $id)
    {
        $compte = CompteBancaire::findOrFail($id);

        // Vérifie que l'utilisateur connecté est bien propriétaire du compte
        if ((int) $compte->user_id !== Auth::id()) {
            abort(403);
        }

        // Validation du montant
        $request->validate([
            'montant' => ['required', 'numeric', 'min:1'],
        ]);

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
            $transaction->compte_dest_id = null; // Aucun compte destinataire
            $transaction->save();

            DB::commit();

            return redirect()->route('compte.details', $compte->id)->with('success', 'Retrait effectué avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue pendant le retrait.']);
        }
}


   



}
