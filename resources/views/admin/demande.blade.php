@extends('admin.base')

@section('content')

<br><br>
<div class="container py-4">
    <div class="card shadow-lg mb-4" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
        <div class="card-header" style="background-color: #ffc107; color: #1e3a34;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Liste des demandes en attente</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput"
                       placeholder="Rechercher une demande..." onkeyup="filterTable()">
            </div>

        <div >
            <table class="table table-hover" id="demandeTable" style=" background-color: #2b4d45; border: 2px solid #ffc107;">
                <thead style=" color: #ffc107;">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $demande)
                        <tr>
                            <td>{{ $demande->id }}</td>
                            <td>{{ ucfirst($demande->type_compte) }}</td>
                            <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $statut = strtolower($demande->statut);
                                    switch ($statut) {
                                        case 'valider': $color = 'success'; break;
                                        case 'rejeter': $color = 'danger'; break;
                                        case 'en_attente': $color = 'warning'; break;
                                        default: $color = 'secondary';
                                    }
                                @endphp
                                <span class="badge bg-{{ $color }} text-dark">
                                    {{ ucfirst($demande->statut) }} 
                                </span>
                            </td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('detail.demande', $demande->id) }}" class="btn btn-sm btn-outline-info">
                                    Plus d'infos
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-light">Aucune demande en attente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            </div>
        </div>
    </div>
</div>

{{-- Script de recherche --}}
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("demandeTable");
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
