@extends('user.base')

@section('content')
<div class="container">
    <h1>Dépot sur le compte #{{ $compte->id }}</h1>

    <form method="POST" action="{{ route('compte.depot.executer', $compte->id) }}">
        @csrf
        <div class="form-group">
            <label for="montant">Montant à déposer :</label>
            <input type="number" name="montant" id="montant" class="form-control" min="1" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Déposer</button>
    </form>
</div>
@endsection
