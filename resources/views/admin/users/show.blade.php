@extends('admin.layout')

@section('title', 'Détails de l\'Utilisateur')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-people"></i> Détails de l'Utilisateur</h1>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td><strong>{{ $user->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email ?? 'Pas d\'email' }}</td>
                    </tr>
                    <tr>
                        <th>Rôle</th>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Administrateur</span>
                            @else
                                <span class="badge bg-primary">Utilisateur</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date de naissance</th>
                        <td>{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Genre</th>
                        <td>
                            @if($user->gender)
                                <span class="badge bg-info">{{ ucfirst($user->gender) }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Créé le</th>
                        <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Modifié le</th>
                        <td>{{ $user->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

