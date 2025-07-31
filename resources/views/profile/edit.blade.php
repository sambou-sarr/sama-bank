@extends('user.base')

@section('content')
<style>
    body {
        background-color: #1e3a34;
    }

    .card {
        background-color: #2b4d45;
        color: white;
        border-radius: 10px;
        border: 1px solid #ffc107;
    }

    .card-header {
        background-color: #2e4f45;
        color: #ffc107;
        font-weight: bold;
    }

    label {
        color: #ffc107;
    }

    .form-control {
        background-color: #1e3a34;
        color: white;
        border: 1px solid #ffc107;
    }

    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .btn-primary {
        background-color: #ffc107;
        color: #1e3a34;
        border: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        font-weight: bold;
    }

    .btn-danger:hover {
        background-color: #bd2130;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: none;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-warning fw-bold">Mon Profil</h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        {{-- Informations sur le profil --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">Informations personnelles</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label"><span class="fw-bold text-white">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control"
                                   value="{{ old('name', $user->nom) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label"><span class="fw-bold text-white">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control"
                                   value="{{ old('prenom', $user->prenom ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label"><span class="fw-bold text-white">Adresse e-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Mettre à jour le mot de passe --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">Changer le mot de passe</div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password"><span class="fw-bold text-white">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password"><span class="fw-bold text-white">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation"><span class="fw-bold text-white">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Suppression du compte --}}
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Suppression du compte</div>
                <div class="card-body">
                    <p class="text-white-50 mb-3">
                        Cette action est irréversible. Vos données seront supprimées définitivement.
                    </p>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Supprimer le compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
