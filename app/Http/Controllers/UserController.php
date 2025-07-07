<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    class UserController extends Controller
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
    $user = Auth::user();
    $comptes = $user->comptes; // relation hasMany
    $totalSolde = $comptes->sum('solde');
    $compteIds = $comptes->pluck('id');

    $dernieresTransactions = Transaction::where(function ($query) use ($compteIds) {
        $query->whereIn('compte_source_id', $compteIds)
              ->orWhereIn('compte_dest_id', $compteIds);
    })
    ->orderByDesc('date')
    ->take(5)
    ->get();

    return view('user.dashboard', compact('user', 'comptes', 'totalSolde', 'dernieresTransactions'));
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
