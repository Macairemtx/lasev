@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="content-header">
    <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(38, 85, 51, 0.1); color: var(--primary-color);">
                <i class="bi bi-music-note-list"></i>
            </div>
            <p class="stat-value">{{ $stats['meditations'] }}</p>
            <p class="stat-label">Méditations</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(76, 175, 80, 0.1); color: var(--primary-light);">
                <i class="bi bi-quote"></i>
            </div>
            <p class="stat-value">{{ $stats['affirmations'] }}</p>
            <p class="stat-label">Affirmations</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(27, 94, 32, 0.1); color: var(--primary-dark);">
                <i class="bi bi-calendar-event"></i>
            </div>
            <p class="stat-value">{{ $stats['events'] }}</p>
            <p class="stat-label">Événements</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(38, 85, 51, 0.1); color: var(--primary-color);">
                <i class="bi bi-people"></i>
            </div>
            <p class="stat-value">{{ $stats['users'] }}</p>
            <p class="stat-label">Utilisateurs</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(76, 175, 80, 0.1); color: var(--primary-light);">
                <i class="bi bi-journal-text"></i>
            </div>
            <p class="stat-value">{{ $stats['blogs'] }}</p>
            <p class="stat-label">Articles de blog</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(27, 94, 32, 0.1); color: var(--primary-dark);">
                <i class="bi bi-bookmark-heart"></i>
            </div>
            <p class="stat-value">{{ $stats['gratitude_journals'] }}</p>
            <p class="stat-label">Journaux de gratitude</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(38, 85, 51, 0.1); color: var(--primary-color);">
                <i class="bi bi-calendar-check"></i>
            </div>
            <p class="stat-value">{{ $stats['retreat_plans'] }}</p>
            <p class="stat-label">Plans de retraite</p>
            @if(isset($stats['retreat_plans_available']))
                <small class="text-muted d-block mt-1">
                    {{ $stats['retreat_plans_available'] }} disponible(s)
                </small>
            @endif
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(76, 175, 80, 0.1); color: var(--primary-light);">
                <i class="bi bi-file-earmark-medical"></i>
            </div>
            <p class="stat-value">{{ $stats['food_comfort_forms'] }}</p>
            <p class="stat-label">Formulaires Retraite</p>
            <a href="{{ route('admin.food-comfort-forms.index') }}" class="btn btn-sm btn-primary mt-2">
                Voir les formulaires
            </a>
        </div>
    </div>
</div>

<!-- Dernières méditations -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-music-note-list"></i> Dernières méditations
            </div>
            <div class="card-body">
                @if($recentMeditations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Durée</th>
                                    <th>Créé le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMeditations as $meditation)
                                    <tr>
                                        <td>{{ $meditation->id }}</td>
                                        <td>{{ $meditation->title }}</td>
                                        <td>{{ $meditation->duration ? gmdate('i:s', $meditation->duration) : 'N/A' }}</td>
                                        <td>{{ $meditation->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.meditations.show', $meditation) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.meditations.index') }}" class="btn btn-primary">
                            Voir toutes les méditations
                        </a>
                    </div>
                @else
                    <p class="text-muted text-center">Aucune méditation pour le moment.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-people"></i> Derniers utilisateurs
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->email ?? 'Pas d\'email' }}</small>
                                </div>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                    {{ $user->role ?? 'user' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center">Aucun utilisateur pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Plans de retraite disponibles -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check"></i> Plans de Retraite Disponibles (Publiés)</span>
                <a href="{{ route('admin.retreat-plans.index') }}" class="btn btn-sm btn-primary">
                    Voir tous les plans
                </a>
            </div>
            <div class="card-body">
                @if(isset($availableRetreatPlans) && $availableRetreatPlans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Durée</th>
                                    <th>Prix</th>
                                    <th>Créé le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableRetreatPlans as $plan)
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
                                        <td>{{ $plan->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.retreat-plans.show', $plan) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Aucun plan de retraite disponible pour le moment.</p>
                    <div class="text-center">
                        <a href="{{ route('admin.retreat-plans.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Créer un plan de retraite
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

