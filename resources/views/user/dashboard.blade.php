@extends('user.base')

@section('content')
<style>
    body {
        background-color: #1e3a34;
    }

    .dashboard-header {
        color: #ffc107;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .dashboard-card {
        background-color: #2b4d45;
        color: white;
        border: 1px solid #ffc107;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.1);
    }

    .dashboard-card h4 {
        color: #ffc107;
        margin-bottom: 10px;
    }

    .action-links a {
        margin-right: 15px;
        color: #ffc107;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .action-links a:hover {
        color: #fff;
        text-decoration: underline;
    }

    .success-message,
    .error-message {
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
    }

    .error-message {
        background-color: #f8d7da;
        color: #721c24;
    }

    .list-group-item {
        background-color: #2b4d45;
        border: none;
    }
</style>

<div class="container py-5">

    {{-- Bienvenue --}}
    <div class="dashboard-card text-center">
        <h2 class="dashboard-header">Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
        <p>Voici un aperçu de votre espace bancaire personnel.</p>
    </div>

    {{-- Bouton ouverture de compte --}}
    <div class="text-center mb-4">
        <a href="{{ route('form.demande') }}" class="btn btn-warning text-dark fw-bold">
            <i class="fas fa-plus-circle"></i> Demander l’ouverture d’un compte
        </a>
    </div>
    
    {{-- Statistiques globales --}}
    <div class="dashboard-card text-center">
        <h4>Solde Total de Vos Comptes</h4>
        <div class="fs-2 fw-bold text-warning">{{ number_format($totalSolde, 0, ',', ' ') }} FCFA</div>
        <p class="text-light mt-2">Nombre de comptes : {{ $comptes->count() }}</p>
    </div>

    {{-- Infos utilisateur --}}
    <div class="dashboard-card">
        <h4>Mes Informations</h4>
        <ul class="list-unstyled">
            <li><strong>Nom complet :</strong> {{ $user->prenom }} {{ $user->nom }}</li>
            <li><strong>Email :</strong> {{ $user->email }}</li>
            <li><strong>Téléphone :</strong> {{ $user->telephone ?? 'Non renseigné' }}</li>
            <li><strong>Client depuis :</strong> {{ $user->created_at->format('d/m/Y') }}</li>
        </ul>
    </div>

 

    {{-- Comptes bancaires --}}
    <div class="dashboard-card">
        <h4>Mes Comptes Bancaires</h4>

        @forelse ($comptes as $compte)
            <div class="p-3 mb-3 border rounded" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ ucfirst($compte->type_compte) }}</strong><br>
                        <small>Numéro : {{ $compte->numb_compte }}</small>
                    </div>
                    <div class="text-end">
                        <div class="text-warning fw-bold">{{ number_format($compte->solde, 0, ',', ' ') }} FCFA</div>
                        <small class="text-success">{{ ucfirst($compte->statut) }}</small>
                    </div>
                </div>

                @if ($compte->statut === 'valide')
                    <div class="mt-3 action-links">
                        <a href="{{ route('carte.pdf', $compte->id) }}"><i class="fas fa-credit-card"></i> Télécharger la carte</a>
                        <a href="{{ route('operations.form', $compte->id) }}"><i class="fas fa-exchange-alt"></i> Faire une opération</a>
                        <a href="{{ route('transactions.pdf', $compte->id) }}"><i class="fas fa-file-download"></i> Historique PDF</a>
                        <a href="{{ route('demande.cloture', $compte->id) }}"><i class="fas fa-times-circle"></i> Fermer le compte</a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-light">Aucun compte bancaire trouvé.</p>
        @endforelse
    </div>
    {{-- Dernières opérations --}}
        <div class="col-12 col-xl-12">
            <div class="card shadow-sm h-100" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
                <div class="card-header" style="background-color: #ffc107; color: #1e3a34;">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Dernières transactions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                           @foreach($dernieresTransactions as $transaction)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong><span class="fw-bold text-warning">{{ ucfirst($transaction->type_operation) }}</strong><br>

                                        @if($transaction->type_operation === 'transfert')
                                            <span class="fw-bold text-white">
                                                De : {{ optional($transaction->compteSource)->numb_compte ?? 'N/A' }}<br>
                                                Vers : {{ optional($transaction->compteDest)->numb_compte ?? 'N/A' }}
                                            </small>
                                        @elseif($transaction->type_operation === 'depot')
                                            <span class="fw-bold text-white">
                                                Dépôt sur : {{ optional($transaction->compteSource)->numb_compte ?? 'N/A' }}
                                            </small>
                                        @elseif($transaction->type_operation === 'retrait')
                                            <span class="fw-bold text-white">
                                                Retrait de : {{ optional($transaction->compteSource)->numb_compte ?? 'N/A' }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-warning">
                                            {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                        <span class="fw-bold text-white">
                                            <br>
                                        <small>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    {{-- Notifications --}}
    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif
</div>
@endsection
