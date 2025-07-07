@extends('user.base')

@section('content')
<style>
    body {
        background-color: #1e3a34;
    }

    label {
        color: #ffc107;
        font-weight: bold;
    }

    select, .form-control {
        background-color: #2b4d45;
        color: white;
        border: 1px solid #ffc107;
    }

    select:focus, .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .form-container {
        max-width: 600px;
        margin: auto;
        background-color: #2b4d45;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
    }

    .btn-warning {
        font-weight: bold;
    }
</style>
<div class="form-container">
    <h2 class="text-warning mb-4 text-center">Demande d'ouverture de compte</h2>

    {{-- Message de confirmation --}}
    @if(session('success'))
        <div class="alert alert-success text-center fw-bold mb-4" style="background-color: #d4edda; color: #155724; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center fw-bold mb-4" style="background-color: #f8d7da; color: #721c24; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('create.demande') }}">
               <form method="POST" action="{{ route('create.demande') }}">
            @csrf
            <input type="hidden" name="id" value="{{ Auth::user()->id }}">

            {{-- Type de compte --}}
            <div class="mb-4">
                <label for="type_compte">Type de compte</label>
                <select name="type_compte" id="type_compte" class="form-control mt-2">
                    <option value="">-- Choisir un type de compte --</option>
                    <option value="courant" {{ old('type_compte') == 'courant' ? 'selected' : '' }}>Compte courant</option>
                    <option value="epargne" {{ old('type_compte') == 'epargne' ? 'selected' : '' }}>Compte épargne</option>
                </select>
                @error('type_compte')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Bouton de soumission --}}
            <div class="text-end">
                <button type="submit" class="btn btn-warning text-dark">
                    <i class="fas fa-paper-plane"></i> Demander un compte bancaire
                </button>
            </div>
        </form>
    </form>
</div>

@endsection
