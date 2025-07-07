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

    .compte-card {
        background-color: #2b4d45;
        color: white;
        border: 1px solid #ffc107;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.1);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: box-shadow 0.3s ease;
    }

    .compte-card:hover {
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        text-decoration: none;
        color: white;
    }

    .compte-info h5 {
        color: #ffc107;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .compte-info small {
        color: #e0e0e0;
    }

    .compte-solde {
        color: #ffc107;
        font-weight: 700;
        font-size: 1.3rem;
        text-align: right;
    }

    .compte-statut {
        margin-top: 5px;
        color: #28a745; /* vert */
        font-weight: 600;
        text-align: right;
        text-transform: capitalize;
    }

    /* Messages notifications */
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
    <h2 class="dashboard-header">Liste des comptes de {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>

    @forelse ($comptes as $compte)
        <a href="{{ route('compte.details', $compte->id) }}" class="compte-card">
            <div class="compte-info">
                <h5>{{ ucfirst($compte->type_compte) }}</h5>
                <small>Numéro : {{ $compte->numb_compte }}</small>
            </div>
            <div>
                <div class="compte-solde">
                    {{ number_format($compte->solde, 0, ',', ' ') }} FCFA
                </div>
                <div>
                    @if($compte->statut === 'valider')
                        <span class="badge bg-success">{{ ucfirst($compte->statut) }}</span>
                    @elseif($compte->statut === 'rejeter')
                        <span class="badge bg-danger">{{ ucfirst($compte->statut) }}</span>
                    @elseif($compte->statut === 'en attente')
                        <span class="badge bg-warning text-dark">{{ ucfirst($compte->statut) }}</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($compte->statut) }}</span>
                    @endif
                </div>
            </div>
        </a>
    @empty
        <p class="text-light">Aucun compte bancaire pour le moment.</p>
    @endforelse

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
