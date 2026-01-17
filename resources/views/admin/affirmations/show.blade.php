@extends('admin.layout')

@section('title', 'Détails de l\'Affirmation')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-quote"></i> Détails de l'Affirmation</h1>
    <div>
        <a href="{{ route('admin.affirmations.edit', $affirmation) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('admin.affirmations.index') }}" class="btn btn-secondary">
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
                        <td>{{ $affirmation->id }}</td>
                    </tr>
                    <tr>
                        <th>Catégorie</th>
                        <td>
                            @if($affirmation->category)
                                <span class="badge bg-info">{{ $affirmation->category->name }}</span>
                            @else
                                <span class="text-muted">Aucune catégorie</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Titre</th>
                        <td><strong>{{ $affirmation->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Contenu</th>
                        <td>{{ $affirmation->body }}</td>
                    </tr>
                    <tr>
                        <th>Créé le</th>
                        <td>{{ $affirmation->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Modifié le</th>
                        <td>{{ $affirmation->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

