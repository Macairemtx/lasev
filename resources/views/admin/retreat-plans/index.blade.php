@extends('admin.layout')

@section('title', 'Plans de Retraite')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-calendar-check"></i> Plans de Retraite</h1>
    <a href="{{ route('admin.retreat-plans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouveau plan
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($plans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr>
                                <td>{{ $plan->id }}</td>
                                <td>
                                    @if($plan->cover_image)
                                        <img src="{{ asset('storage/' . $plan->cover_image) }}" 
                                             alt="{{ $plan->title }}" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <span class="badge bg-secondary">Aucune</span>
                                    @endif
                                </td>
                                <td><strong>{{ $plan->title }}</strong></td>
                                <td>{{ $plan->duration_days }} jour(s)</td>
                                <td>
                                    @if($plan->price)
                                        {{ number_format($plan->price, 2) }} €
                                    @else
                                        <span class="text-muted">Gratuit</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->status === 'available')
                                        <span class="badge bg-success">Disponible</span>
                                    @elseif($plan->status === 'on_request')
                                        <span class="badge bg-warning">Sur demande</span>
                                    @else
                                        <span class="badge bg-info">Bientôt</span>
                                    @endif
                                </td>
                                <td>{{ $plan->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.retreat-plans.show', $plan) }}" class="btn btn-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.retreat-plans.edit', $plan) }}" class="btn btn-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.retreat-plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan de retraite ?');">
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $plans->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-check" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun plan de retraite trouvé.</p>
                <a href="{{ route('admin.retreat-plans.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer un plan de retraite
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

