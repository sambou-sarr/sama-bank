<?php

namespace App\Http\Controllers;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NouvelleDemandeNotification;
use Illuminate\Support\Facades\Notification;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.demande');
    }
    public function liste_demande() {
       $demandes = Demande::where('statut', 'en_attend')->get();
        return view('admin.dashboard',compact('demandes'));
    }


    public function store(Request $request)
    {
        
        // Valide les données envoyées
        $request->validate([
            'type_compte' => 'required|in:courant,epargne',
            // autres validations si besoin
        ]);

        $user = Auth::user();

        // 1. Créer d'abord le compte bancaire (avec solde 0, statut 'en_attente')
        $compte = new CompteBancaire();
        $compte->numb_compte = $this->genererNumeroCompte();  // méthode à créer
        $compte->code_banque = '12345';                       // fixe ou dynamique
        $compte->code_guichet = '12345';
        $compte->cle_RIB = $this->genererCleRIB();            // méthode à créer
        $compte->solde = 0;
        $compte->type_compte = $request->type_compte;
        $compte->statut = 'en_attente';                        // compte pas encore validé
        $compte->user_id = $user->id;
        $compte->save();

        // 2. Créer la demande liée à ce compte
        $demande = new Demande();
        $demande->compte_id = $compte->id;
        $demande->type_compte = $request->type_compte;
        $demande->type = 'validation';
        $demande->statut = 'en_attente';
        $demande->date_traitement = null;
        $demande->save();

        // 3. Créer la carte liée à ce compte bancaire
        $carte = new CarteBancaire(); // ou le nom de ton modèle Carte
        $carte->compte_id = $compte->id;
        $carte->numero_carte = $this->genererNumeroCarte(); // méthode à créer pour générer un numéro de carte
        $carte->date_exp = now()->addYears(3);               // date d'expiration dans 3 ans par exemple
        $carte->CVV = rand(100, 999);                        // un CVV aléatoire à 3 chiffres
        $carte->statut = 'active';                           // ou 'en_attente' selon ta logique
        $carte->save();
        // Trouver l'admin (ou tous les admins)
        $admins = \App\Models\User::where('role', 'admin')->get();

        // Envoyer la notification à tous les admins
        Notification::send($admins, new NouvelleDemandeNotification($user, $compte));
        return redirect()->route('form.demande')->with('success', 'Votre demande a été envoyée avec succès.');

    }

    private function genererNumeroCarte()
        {
            // Génère un numéro de carte fictif à 16 chiffres
            $numero = '';
            for ($i = 0; $i < 16; $i++) {
                $numero .= rand(0, 9);
            }
            return $numero;
        }

    // Méthodes pour générer numéro compte et clé RIB (exemples)
    private function genererNumeroCompte()
    {
        return str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
    }

    private function genererCleRIB()
    {
        return str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
    }

  
}
