@extends('user.base') 
@section('content')

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow" style="background-color: #1e3a34; color: #fff;">
        <div class="card-header text-center">
            <h4>Inscription</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text"
                           id="nom"
                           name="nom"
                           value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           required autofocus autocomplete="nom">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Prénom --}}
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text"
                           id="prenom"
                           name="prenom"
                           value="{{ old('prenom') }}"
                           class="form-control @error('prenom') is-invalid @enderror"
                           required autocomplete="prenom">
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Téléphone --}}
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text"
                           id="telephone"
                           name="telephone"
                           value="{{ old('telephone') }}"
                           class="form-control @error('telephone') is-invalid @enderror"
                           required autocomplete="telephone">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lien connexion + bouton --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a class="text-warning" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>

                    <button type="submit" class="btn btn-outline-light">
                        S’inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
