@extends('admin.base')
    @section('content')
    <br><br>
    {{-- Message de connexion --}}
    <div id="admin-alert" class="max-w-4xl mx-auto mt-6 px-4">
        <div class="bg-[#1e3a34] border-l-4 border-[#ffc107] text-white p-4 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <i class="fas fa-user-shield text-[#ffc107] text-2xl mr-3"></i>
                <div>
                    <h4 class="font-semibold text-lg mb-1">Bienvenue, Administrateur !</h4>
                    <p class="text-sm">Vous êtes connecté avec les privilèges d’administration. Gérez les comptes, transactions et utilisateurs depuis votre tableau de bord.</p>
                </div>
            </div>
        </div>
    </div>

<br><br>
<div class="container-fluid mt-4">
    <div class="row g-4">
        <!-- Cartes de statistiques -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color: #ffc107; color: #1e3a34;">
                            <i class="fas fa-piggy-bank fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ number_format($stats['soldeTotal'], 0, ',', ' ') }} FCFA</h5>
                            <small style="color: #ffc107;">Solde total des comptes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 me-3">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $stats['transactionsJour'] }}</h5>
                            <small style="color: #ffc107;">Transactions aujourd'hui</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-university fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $stats['comptesactifs'] }}</h5>
                            <small style="color: #ffc107;">Comptes actifs</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stat-card h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $stats['clientsActifs'] }}</h5>
                            <small style="color: #ffc107;">Clients actifs</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique et Dernières transactions -->
        <div class="col-12 col-xl-8">
            <div class="chart-container shadow-sm">
                <canvas id="transactionsChart" width="800" height="400"></canvas>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card shadow-sm h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-header" style="background-color: #ffc107; color: #1e3a34;">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Dernières transactions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($transactions as $transaction)
                            <div class="list-group-item mb-2" style="background-color: #2b4d45; color: white; border: 1px solid #ffc107; border-radius: 8px;">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Transaction #{{ $transaction->id }}</h6>
                                    <small>{{ ($transaction->created_at) }}</small>
                                </div>
                                <p class="mb-1">
                                    Client : {{ $transaction->compteSource->user->prenom." ".$transaction->compteSource->user->nom ?? 'Inconnu' }}<br>
                                    Montant : {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA<br>
                                    Opération : {{ ucfirst($transaction->type_operation) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center">Aucune transaction récente.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>



    {{-- Script pour alerte --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                const alert = document.getElementById('admin-alert');
                if (alert) alert.style.display = 'none';
            }, 5000);
        });
    </script>
 @endsection
