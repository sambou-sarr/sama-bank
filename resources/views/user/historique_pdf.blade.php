<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
             font-family: DejaVu Sans; 
             font-size: 12px; 
             background-color: #1e3a34;
             color: white;
            }
        table {
             width: 100%; border-collapse: collapse;
              margin-top: 20px;
             }
        th, td {
             border: 1px solid #ccc;
             padding: 8px; text-align: center;
             }
        th { 
            background-color: #ffc107;
             }
    </style>
</head>
<body>
    <h2 style="text-align: center; color :#ffc107">Historique des Transactions</h2>
    <table>
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
</body>
</html>
