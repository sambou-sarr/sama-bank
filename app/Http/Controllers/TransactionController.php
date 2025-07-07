<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\CompteBancaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
   
     // Afficher historique 
    public function historique($id)
    {
        $transactions = Transaction::where('compte_source_id', $id)->orWhere('compte_dest_id', $id)->orderBy('date', 'desc')->get();

        return view('user.historique', compact('transactions'));
    }
   
     // Exécuter le transfert
    public function executerTransfert(Request $request, $id)
        {
            $compte = CompteBancaire::findOrFail($id);

            if ((int)$compte->user_id !== Auth::id()) {
                abort(403);
            }

            $request->validate([
                'destinataire' => ['required', 'exists:compte_bancaires,numb_compte'],
                'montant' => ['required', 'numeric', 'min:1'],
            ]);

            $destinataire = CompteBancaire::where('numb_compte', $request->destinataire)->first();

            if (!$destinataire) {
                return back()->withErrors(['compte_destinataire' => 'Compte destinataire invalide']);
            }

            if ($compte->solde < $request->montant) {
                return back()->withErrors(['montant' => 'Solde insuffisant']);
            }

            DB::beginTransaction();

            try {
                // Débit du compte source
                $compte->solde -= $request->montant;
                $compte->save();

                // Crédit du compte destinataire
                $destinataire->solde += $request->montant;
                $destinataire->save();

                // Création et sauvegarde manuelle de la transaction
                $transaction = new Transaction();
                $transaction->type_operation    = 'transfert';
                $transaction->montant           = $request->montant;
                $transaction->date              = Carbon::now();
                $transaction->compte_source_id  = $compte->id;
                $transaction->compte_dest_id    = $destinataire->id;
                $transaction->save();

                DB::commit();

                return redirect()->route('compte.details', $compte->id)->with('success', 'Transfert effectué avec succès.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Une erreur est survenue pendant le transfert.']);
            }
    }

    public function pdf($id) 
    {
        // On récupère les transactions du compte avec l'ID donné
        $transactions = Transaction::where('compte_source_id', $id)
                                ->orWhere('compte_dest_id', $id)
                                ->get();

        $pdf = Pdf::loadView('user.historique_pdf', compact('transactions'));

        return $pdf->download('historique-transactions.pdf');
    }

    //liste des transaction par user

    public function mesTransactions()
    {   
         $user = Auth::user();

    $compteIds = $user->comptes_bancaires->pluck('id');

    if ($compteIds->isEmpty()) {
        return view('user.transactions', ['transactions' => collect()]);
    }

    $transactions = Transaction::whereIn('compte_source_id', $compteIds)
        ->orWhereIn('compte_dest_id', $compteIds)
        ->latest()
        ->paginate(10);

    return view('user.transactions', compact('transactions'));
    }


}
