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

    .btn-outline-light {
        border: 2px solid #ffc107;
        color: #ffc107;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: #ffc107;
        color: #1e3a34;
    }

    .form-control {
        background-color: #1e3a34;
        border: 1px solid #ffc107;
        color: white;
    }

    .form-label {
        color: #ffc107;
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
</style>

<div class="container py-5">
    <h2 class="dashboard-header">Détails du compte bancaire</h2>

    <div class="dashboard-card d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-warning">{{ $compte->type_compte }}</h4>
            <p>Numéro : <span class="text-light">{{ $compte->numb_compte }}</span></p>
            <p>Statut : <span class="text-success">{{ ucfirst($compte->statut) }}</span></p>
        </div>

        <div class="text-end">
            <p class="fs-3 fw-bold text-warning">{{ number_format($compte->solde, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <div class="mt-4 d-flex flex-wrap gap-3">
        <a href="{{ route('compte.transfert.formulaire', $compte->id) }}" class="btn btn-outline-light"><i class="fas fa-exchange-alt"></i>. Transfert</a>
        <a href="{{ route('compte.historique', $compte->id) }}" class="btn btn-outline-light"><i class="fas fa-file-download"></i>. Historique</a>
        <a href="{{ route('compte.depot.formulaire', $compte->id) }}" class="btn btn-outline-light"><i class="fas fa-exchange-alt"></i>. Dépôt</a>
        <a href="{{ route('compte.retrait.formulaire', $compte->id) }}" class="btn btn-outline-light"><i class="fas fa-exchange-alt"></i>. Retrait</a>
        <a href="{{ route('compte.carte', $compte->id) }}" class="btn btn-outline-light"><i class="fas fa-credit-card"></i>. Ma Carte</a>
    </div>

    {{-- Formulaire de transfert si demandé --}}
    @if(session('showTransferForm'))
        <div class="dashboard-card mt-5">
            <h5 class="mb-3 text-warning">Effectuer un transfert</h5>
            <form method="POST" action="{{ route('compte.transfert.submit', $compte->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="destinataire" class="form-label">Numéro du compte destinataire</label>
                    <input type="text" class="form-control" id="destinataire" name="destinataire" required>
                </div>
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (FCFA)</label>
                    <input type="number" class="form-control" id="montant" name="montant" min="100" max="{{ $compte->solde }}" required>
                </div>
                <button type="submit" class="btn btn-warning text-dark fw-bold">Transférer</button>
            </form>
        </div>
    @endif

    {{-- Notifications --}}
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif
</div>
@endsection
