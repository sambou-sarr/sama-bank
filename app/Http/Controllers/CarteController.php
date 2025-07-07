<?php

namespace App\Http\Controllers;

use App\Models\CarteBancaire;
use Illuminate\Http\Request;
use App\Models\CompteBancaire;
use Barryvdh\DomPDF\Facade\Pdf;

class CarteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
      $carte = CarteBancaire::with('compte.user')->findOrFail($id);

    // Concatène prénom + nom du titulaire
    $nomTitulaire = $carte->compte->user->prenom . ' ' . $carte->compte->user->nom;

    return view('user.carte', compact('carte', 'nomTitulaire'));
    }

    public function download($id)
    {
        // 1. Récupération de la carte avec son compte et utilisateur
        $carte = CarteBancaire::with('compte.user')->findOrFail($id);

        // 2. Concaténation du nom du titulaire
        $nomTitulaire = $carte->compte->user->prenom . ' ' . $carte->compte->user->nom;

        // 3. Préparation des données à passer à la vue PDF
        $data = [
            'carte' => $carte,
            'nomTitulaire' => $nomTitulaire,
        ];

        // 4. Génération du PDF
        $pdf = Pdf::loadView('user.carte_pdf', $data);

        // 5. Téléchargement avec un nom de fichier personnalisé
        return $pdf->download('carte_bancaire_' . strtolower($carte->compte->user->nom) . '.pdf');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
