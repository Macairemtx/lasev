@extends('admin.layout')

@section('title', 'Gestion des Affirmations')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-quote"></i> Gestion des Affirmations</h1>
    <a href="{{ route('admin.affirmations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle affirmation
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($affirmations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Contenu</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($affirmations as $affirmation)
                            <tr>
                                <td>{{ $affirmation->id }}</td>
                                <td><strong>{{ $affirmation->title }}</strong></td>
                                <td>
                                    @if($affirmation->category)
                                        <span class="badge bg-info">{{ $affirmation->category->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Aucune</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($affirmation->body, 50) }}</td>
                                <td>{{ $affirmation->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.affirmations.show', $affirmation) }}" class="btn btn-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.affirmations.edit', $affirmation) }}" class="btn btn-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.affirmations.destroy', $affirmation) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affirmation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($affirmations->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $affirmations->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-quote" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune affirmation trouvée.</p>
                <a href="{{ route('admin.affirmations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer une affirmation
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

