@extends('user.base') {{-- ou ton layout de base --}}
@section('content')

<div class="container mt-5" style="max-width: 500px;">
    {{-- Message de session --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card shadow" style="background-color: #1e3a34; color: #fff;">
        <div class="card-header text-center">
            <h4>Connexion</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required autofocus autocomplete="username">
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
                           required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Se souvenir de moi --}}
                <div class="form-check mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           id="remember">
                    <label class="form-check-label" for="remember">
                        Se souvenir de moi
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a class="text-warning" href="/register">
                        Inscription
                    </a>
                    <button type="submit" class="btn btn-outline-light">
                        Connexion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
