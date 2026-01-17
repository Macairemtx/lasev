@extends('admin.layout')

@section('title', 'Détails de la Méditation')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-eye"></i> Détails de la méditation</h1>
    <div>
        <a href="{{ route('admin.meditations.edit', $meditation) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('admin.meditations.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informations générales
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 200px;">ID</th>
                        <td>{{ $meditation->id }}</td>
                    </tr>
                    <tr>
                        <th>Titre</th>
                        <td><strong>{{ $meditation->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code>{{ $meditation->slug ?? 'N/A' }}</code></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $meditation->description ?? 'Aucune description' }}</td>
                    </tr>
                    <tr>
                        <th>Durée</th>
                        <td>
                            @if($meditation->duration)
                                {{ gmdate('i:s', $meditation->duration) }} ({{ $meditation->duration }} secondes)
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Créé le</th>
                        <td>{{ $meditation->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Modifié le</th>
                        <td>{{ $meditation->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-music"></i> Fichier audio
            </div>
            <div class="card-body">
                @if($meditation->media)
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th>ID</th>
                            <td>{{ $meditation->media->id }}</td>
                        </tr>
                        <tr>
                            <th>Titre</th>
                            <td>{{ $meditation->media->title }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>
                                <span class="badge bg-success">{{ $meditation->media->media_type }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Chemin</th>
                            <td><code class="small">{{ $meditation->media->file_path }}</code></td>
                        </tr>
                        <tr>
                            <th>Durée</th>
                            <td>
                                @if($meditation->media->duration)
                                    {{ gmdate('i:s', $meditation->media->duration) }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>
                @else
                    <p class="text-muted text-center">Aucun fichier audio associé</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="bi bi-trash"></i> Actions
            </div>
            <div class="card-body">
                <form action="{{ route('admin.meditations.destroy', $meditation) }}" method="POST" 
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette méditation ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Supprimer la méditation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

