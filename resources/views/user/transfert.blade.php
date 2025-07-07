@extends('user.base') {{-- adapte à ton layout --}}

@section('content')
<div class="container">
    <h1>Transfert d'argent - Compte n° {{ $compte->numb_compte }}</h1>

    <form method="POST" action="{{ route('compte.transfert.executer', $compte->id) }}">
        @csrf

        <div class="mb-3">
            <label for="destinataire" class="form-label">Numéro du compte destinataire</label>
            <input type="text" name="destinataire" id="destinataire" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" name="montant" id="montant" class="form-control" required min="1" step="any">
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection
