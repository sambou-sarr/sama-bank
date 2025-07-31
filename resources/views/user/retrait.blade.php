@extends('user.base')

@section('content')
<div class="container py-5">
    <h2 class="text-warning mb-4">Faire un retrait</h2>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Message d’erreur général (limite de retraits) --}}
    @if ($errors->has('error'))
        <div class="alert alert-danger">{{ $errors->first('error') }}</div>
    @endif

    {{-- Message d’erreur de validation (montant requis, etc.) --}}
    @if ($errors->has('montant'))
        <div class="alert alert-danger">{{ $errors->first('montant') }}</div>
    @endif

    <form action="{{ route('compte.retrait.executer', $compte->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="montant" class="form-label text-white">Montant à retirer</label>
            <input type="number" class="form-control" id="montant" name="montant" required>
        </div>
        <button type="submit" class="btn btn-warning text-dark fw-bold">Valider le retrait</button>
    </form>
</div>
@endsection
