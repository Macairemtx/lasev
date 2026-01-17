@extends('admin.layout')

@section('title', 'Gestion des Événements')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-calendar-event"></i> Gestion des Événements</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvel événement
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Prix</th>
                            <th>Participants</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td><strong>{{ $event->title }}</strong></td>
                                <td>{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $event->location ?? 'N/A' }}</td>
                                <td>
                                    @if($event->price)
                                        {{ number_format($event->price, 2) }} €
                                    @else
                                        <span class="text-muted">Gratuit</span>
                                    @endif
                                </td>
                                <td>{{ $event->current_participants ?? 0 }}</td>
                                <td>
                                    @if($event->status === 'upcoming')
                                        <span class="badge bg-primary">À venir</span>
                                    @elseif($event->status === 'ongoing')
                                        <span class="badge bg-success">En cours</span>
                                    @elseif($event->status === 'completed')
                                        <span class="badge bg-secondary">Terminé</span>
                                    @else
                                        <span class="badge bg-danger">Annulé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
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
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-event" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun événement trouvé.</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer un événement
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

