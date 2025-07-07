@extends('admin.base')
@section('content')

<style>
    body {
        background-color: #122822;
    }
    .card {
        border-radius: 10px;
        background-color: #1e3a34;
        border: 1px solid #ffc107;
        color: white;
    }

    .card-header {
        font-weight: bold;
        font-size: 1.2rem;
        background-color: #2b4d45;
        border-bottom: 1px solid #ffc107;
        color: #ffc107;
    }

    dl.row dt {
        font-weight: 600;
        color: #ffc107;
    }

    dl.row dd {
        margin-bottom: 1rem;
        color: white;
    }

    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #ffc107;
        background-color: #122822;
        color: white;
    }

    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 5px #ffc107;
        border-color: #ffc107;
    }

    .btn-success, .btn-secondary {
        border-radius: 8px;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.6em 1em;
        border-radius: 20px;
    }

    .alert {
        border-radius: 8px;
    }

    .container-center {
        max-width: 800px;
        margin: 0 auto;
    }
</style>

<div class="container mt-5 container-center">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-xl text-warning">Détail de la Demande #{{ $demande->id }}</h1>
        <a href="{{ route('demande') }}" class="btn btn-secondary">Retour aux demandes</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Informations client -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informations du client</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nom</dt>
                <dd class="col-sm-8">{{ $demande->compte->user->nom }}</dd>

                <dt class="col-sm-4">Prénom</dt>
                <dd class="col-sm-8">{{ $demande->compte->user->prenom }}</dd>

                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $demande->compte->user->email }}</dd>

                <dt class="col-sm-4">Téléphone</dt>
                <dd class="col-sm-8">{{ $demande->compte->user->telephone }}</dd>

                <dt class="col-sm-4">Type de compte</dt>
                <dd class="col-sm-8">{{ ucfirst($demande->compte->type_compte) }}</dd>

                <dt class="col-sm-4">Date de la demande</dt>
                <dd class="col-sm-8">{{ date('d/m/Y H:i', strtotime($demande->date_demande)) }}</dd>

                <dt class="col-sm-4">Statut actuel</dt>
                <dd class="col-sm-8">
                    @php
                        $statut = strtolower($demande->statut);
                        switch ($statut) {
                            case 'valider': $color = 'success'; break;
                            case 'rejeter': $color = 'danger'; break;
                            case 'en_attente': $color = 'warning'; break;
                             default: $color = 'secondary';
                        }
                    @endphp
                    <span class="badge bg-{{ $color }} text-white">
                        {{ ucfirst($demande->statut) }} 
                    </span>
                </dd>

                @if($demande->statut === 'rejetée' && $demande->raison_rejet)
                    <dt class="col-sm-4">Raison du rejet</dt>
                    <dd class="col-sm-8">{{ $demande->raison_rejet }}</dd>
                @endif
            </dl>
        </div>
    </div>

    {{-- Formulaire si la demande est en attente --}}
    @if (strtolower($demande->statut) === 'en_attente')
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Action sur la demande</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('demande.action', $demande->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="action" class="form-label">Choisir une action :</label>
                        <select name="action" id="action" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="valider" {{ old('action') == 'valider' ? 'selected' : '' }}>Valider la demande</option>
                            <option value="rejeter" {{ old('action') == 'rejeter' ? 'selected' : '' }}>Rejeter la demande</option>
                        </select>
                    </div>

                    <div class="mb-3" id="raison_rejet_field" style="display: none;">
                        <label for="raison_rejet" class="form-label">Raison du rejet :</label>
                        <textarea name="raison_rejet" id="raison_rejet" class="form-control" rows="3">{{ old('raison_rejet') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Soumettre</button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('action').addEventListener('change', function () {
                const rejetField = document.getElementById('raison_rejet_field');
                rejetField.style.display = this.value === 'rejeter' ? 'block' : 'none';
                document.getElementById('raison_rejet').required = (this.value === 'rejeter');
            });

            window.addEventListener('DOMContentLoaded', () => {
                if (document.getElementById('action').value === 'rejeter') {
                    document.getElementById('raison_rejet_field').style.display = 'block';
                    document.getElementById('raison_rejet').required = true;
                }
            });
        </script>
    @endif
</div>
@endsection
