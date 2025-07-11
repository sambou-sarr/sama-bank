<?php

namespace App\Http\Controllers;

use App\Models\CompteBancaire;
use App\Models\Demande;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\EtatDemandeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => [
                'users' => User::count(),
                'clientsActifs' => User::where('role', 'user')->count(),
                'admins' => User::where('role', 'admin')->count(),
                'comptes' => CompteBancaire::count(),
                'transactions' => Transaction::count(),
               'soldeTotal' => DB::table('compte_bancaires')
                ->select(DB::raw("SUM(CAST(solde  AS DECIMAL(10,2))) as total"))
                ->value('total'),
                'transactionsJour' => Transaction::whereDate('created_at', now()->toDateString())->count(),
                'comptesactifs' => CompteBancaire::where('statut', 'valider')->count()
            ],
            'transactions' => Transaction::with('compteSource.user')->latest()->take(5)->get(),
            'derniersClients' => User::where('role', 'user')->latest()->take(5)->get()
        ]);
    }


    public function detail_demande($id) 
    {
        $demande = Demande::with(['compte.user'])->findOrFail($id);
        return view('admin.info_demande', compact('demande'));
    }
    public function demande()
    {
        $demandes = Demande::with(['compte.user'])->get();
        return view('admin.demande', compact('demandes'));
    }

  
    public function transactions()
    {
        $transactions = Transaction::latest()->paginate(10); // 10 par page
        return view('admin.transactions', compact('transactions'));
    }

  public function users()
    {
        $users = User::latest()->paginate(10); // 10 par page
        return view('admin.user', compact('users'));
    }

    public function traiterAction(Request $request, $id)
    {
      $request->validate([
            'action' => 'required|in:valider,rejeter',
            'raison_rejet' => 'required_if:action,rejeter|max:255',
        ]);

        $demande = Demande::findOrFail($id);

        if ($request->action === 'valider') {
            $demande->statut = 'valider';
            $demande->raison_rejet = null;

            // Mise à jour du statut du compte
            if ($demande->compte_id) {
                $compte = CompteBancaire::find($demande->compte_id);
                if ($compte) {
                    $compte->statut = 'valider'; // ou tout autre statut logique
                    $compte->save();
                }
            }

        } elseif ($request->action === 'rejeter') {
            $demande->statut = 'rejeter';
            $demande->raison_rejet = $request->raison_rejet;

            // Mise à jour du statut du compte (facultatif selon ton besoin)
            if ($demande->compte_id) {
                $compte = CompteBancaire::find($demande->compte_id);
                if ($compte) {
                    $compte->statut = 'rejeter'; // ou 'rejeté', selon ton système
                    $compte->save();
                }
            }
        }

        $demande->save();

        $user = $demande->compte->user;
        $user->notify(new EtatDemandeNotification($demande->statut, $demande->raison_rejet));

        return redirect()->route('demande')->with('success', 'Demande mise à jour avec succès.');

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
