@extends('user.base')

@section('content')
<style>
    .custom-table {
        width: 100%;
        background-color: #1e3a34;
        color: white;
        border-collapse: separate;
        border-spacing: 0;
        border: 2px solid #ffc107;
        border-radius: 10px;
        overflow: hidden;
    }

    .custom-table thead {
        background-color: #ffc107;
        color: #1e3a34;
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #ffc107;
        padding: 12px;
        text-align: center;
    }

    .custom-table tbody tr:hover {
        background-color: #2b4d45;
        color: white;
    }

    .btn-pdf {
        display: block;
        margin: 30px auto;
        padding: 10px 25px;
        background-color: #ffc107;
        color: #1e3a34;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.3s ease;
        text-align: center;
        width: max-content;
    }

    .btn-pdf:hover {
        background-color: #e0a800;
        color: white;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #ffc107;">Historique des Transactions</h2>

    @if($transactions->isEmpty())
        <div class="alert alert-warning text-center">Aucune transaction trouvée.</div>
    @else
    <div class="table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Compte Source</th>
                    <th>Compte Destinataire</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ ucfirst($transaction->type_operation) }}</td>
                    <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                    <td>{{ $transaction->compte_source_id }}</td>
                    <td>{{ $transaction->compte_dest_id ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<a href="{{ route('transactions.pdf', $id) }}" class="btn-pdf" target="_blank">
    Télécharger la liste en PDF
</a>

@endsection
