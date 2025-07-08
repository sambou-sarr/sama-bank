@extends('admin.base')

@section('content')
<br><br>
<div class="container py-4">
    <div class="card shadow-lg mb-4" style="background-color: #1e3a34; color: white; border: 2px solid #ffc107;">
        <div class="card-header" style="background-color: #ffc107; color: #1e3a34;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-users me-2"></i>Liste des Utilisateurs</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un utilisateur..." onkeyup="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="userTable" style="background-color: #2b4d45; border: 2px solid #ffc107;">
                    <thead style="color: #ffc107;">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Date d’inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ ucfirst($user->nom) }}</td>
                            <td>{{ ucfirst($user->prenom) }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-light">Aucun utilisateur trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Script JS pour la recherche --}}
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("userTable");
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
