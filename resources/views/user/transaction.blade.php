@extends('user.base')

@section('content')
<style> 
    .pagination {
        display: flex;
        justify-content: center;
        padding-left: 0;
        list-style: none;
        margin-top: 30px;
        gap: 5px;
    }

    .page-item {
        display: inline;
    }

    .page-link {
        color: #1e3a34;
        background-color: #ffc107;
        border: 1px solid #ffc107;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .page-link:hover {
        background-color: #e0a800;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #1e3a34;
        border-color: #1e3a34;
        color: #ffc107;
    }

    .page-item.disabled .page-link {
        background-color: #ccc;
        border-color: #ccc;
        color: #666;
        cursor: not-allowed;
    }
</style>
<br><br>
<div class="container py-4">
    <div class="card shadow-lg mb-4" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
        <div class="card-header" style="background-color: #ffc107; color: #1e3a34;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Liste des transactions</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher une transaction..." onkeyup="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="transactionTable" style="background-color: #2b4d45; border: 2px solid #ffc107;">
                    <thead style="color: #ffc107;">
                        <tr>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Compte Source</th>
                            <th>Compte Destinataire</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ ucfirst($transaction->type_operation) }}</td>
                            <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                            <td>{{ $transaction->compte_source_id }}</td>
                            <td>{{ $transaction->compte_dest_id ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-light">Aucune transaction trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Script de recherche --}}
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("transactionTable");
        const trs = table.getElementsByTagName("tr");

        for (let i = 1; i < trs.length; i++) {
            const tds = trs[i].getElementsByTagName("td");
            let visible = false;
            for (let td of tds) {
                if (td.textContent.toUpperCase().includes(filter)) {
                    visible = true;
                    break;
                }
            }
            trs[i].style.display = visible ? "" : "none";
        }
    }
</script>

@endsection
