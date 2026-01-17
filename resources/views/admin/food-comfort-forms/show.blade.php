@extends('admin.layout')

@section('title', 'Détails du Formulaire de Confort Alimentaire')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-file-earmark-medical"></i> Détails du Formulaire</h1>
    <div>
        <a href="{{ route('admin.food-comfort-forms.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Informations du participant -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-person"></i> Informations du Participant
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="250">Nom complet</th>
                        <td><strong>{{ $form->first_name }} {{ $form->last_name }}</strong></td>
                    </tr>
                    @if($form->user)
                        <tr>
                            <th>ID Utilisateur</th>
                            <td><code>{{ $form->user->id }}</code></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><code>{{ $form->user->email }}</code></td>
                        </tr>
                        <tr>
                            <th>Identifiant (Device ID)</th>
                            <td><code>{{ $form->user->device_id ?? 'N/A' }}</code></td>
                        </tr>
                        <tr>
                            <th>Rôle</th>
                            <td>
                                @if($form->user->role === 'admin')
                                    <span class="badge bg-danger">Administrateur</span>
                                @else
                                    <span class="badge bg-primary">Utilisateur</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    @if($form->retreatPlan)
                        <tr>
                            <th>Plan de Retraite</th>
                            <td><strong>{{ $form->retreatPlan->title }}</strong></td>
                        </tr>
                        <tr>
                            <th>Durée</th>
                            <td>{{ $form->retreatPlan->duration_days }} jour(s)</td>
                        </tr>
                        <tr>
                            <th>Prix</th>
                            <td>
                                @if($form->retreatPlan->price)
                                    {{ number_format($form->retreatPlan->price, 2) }} €
                                @else
                                    <span class="text-muted">Sur demande</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Date de soumission</th>
                        <td>{{ $form->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Section 1: Santé & Sécurité -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-shield-check"></i> 1. Santé & Sécurité
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="250">Allergies alimentaires</th>
                        <td>
                            @if($form->has_allergies)
                                <span class="badge bg-danger">Oui</span>
                            @else
                                <span class="badge bg-success">Non</span>
                            @endif
                        </td>
                    </tr>
                    @if($form->has_allergies)
                        <tr>
                            <th>Détails de l'allergie</th>
                            <td>{{ $form->allergy_food ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Type d'allergie</th>
                            <td>
                                @if($form->allergy_type)
                                    @foreach((array)$form->allergy_type as $type)
                                        <span class="badge bg-warning">{{ ucfirst($type) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Intolérances</th>
                        <td>{{ $form->intolerances ?? 'Aucune' }}</td>
                    </tr>
                    <tr>
                        <th>Régimes spécifiques</th>
                        <td>
                            @if($form->specific_diets && is_array($form->specific_diets) && count($form->specific_diets) > 0)
                                @foreach($form->specific_diets as $diet)
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $diet)) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucun</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Section 2: Préférences & Plaisirs -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-heart"></i> 2. Préférences & Plaisirs
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="250">Ingrédients "bonheur"</th>
                        <td>
                            @if($form->happiness_ingredients && is_array($form->happiness_ingredients))
                                @foreach($form->happiness_ingredients as $ingredient)
                                    <span class="badge bg-success">{{ $ingredient }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucun</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Aliments dégoûtés</th>
                        <td>{{ $form->disliked_foods ?? 'Aucun' }}</td>
                    </tr>
                    <tr>
                        <th>Niveau d'épices</th>
                        <td>
                            @if($form->spice_level)
                                <span class="badge bg-info">
                                    {{ ucfirst(str_replace('_', ' ', $form->spice_level)) }}
                                </span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Inspirations culinaires</th>
                        <td>
                            @if($form->culinary_inspirations && is_array($form->culinary_inspirations))
                                @foreach($form->culinary_inspirations as $cuisine)
                                    <span class="badge bg-primary">{{ ucfirst($cuisine) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Plat réconfort</th>
                        <td>{{ $form->comfort_dish ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Section 3: Habitudes & Boissons -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-cup-hot"></i> 3. Habitudes & Boissons
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="250">Préférence petit-déjeuner</th>
                        <td>
                            @if($form->breakfast_preference)
                                <span class="badge bg-warning">
                                    {{ ucfirst(str_replace('_', ' ', $form->breakfast_preference)) }}
                                </span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Boissons chaudes</th>
                        <td>
                            @if($form->hot_drinks && is_array($form->hot_drinks))
                                @foreach($form->hot_drinks as $drink)
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $drink)) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Boissons végétales</th>
                        <td>
                            @if($form->plant_drinks && is_array($form->plant_drinks))
                                @foreach($form->plant_drinks as $drink)
                                    <span class="badge bg-success">{{ ucfirst(str_replace('_', ' ', $drink)) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Besoin de collations</th>
                        <td>
                            @if($form->needs_snacks)
                                <span class="badge bg-success">Oui</span>
                            @else
                                <span class="badge bg-secondary">Non</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Commentaires -->
        @if($form->free_comments)
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-chat-left-text"></i> Commentaires Libres
            </div>
            <div class="card-body">
                <p>{{ $form->free_comments }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-gear"></i> Actions
            </div>
            <div class="card-body">
                @if($form->user)
                    <a href="{{ route('admin.users.show', $form->user) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-person"></i> Voir l'utilisateur
                    </a>
                @endif
                @if($form->retreatPlan)
                    <a href="{{ route('admin.retreat-plans.show', $form->retreatPlan) }}" class="btn btn-info w-100 mb-2">
                        <i class="bi bi-calendar-check"></i> Voir le plan de retraite
                    </a>
                @endif
                <form action="{{ route('admin.food-comfort-forms.destroy', $form) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formulaire ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Supprimer le formulaire
                    </button>
                </form>
            </div>
        </div>

        <!-- Informations de connexion -->
        @if($form->user)
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-key"></i> Identifiants de Connexion
            </div>
            <div class="card-body">
                <p><strong>Email:</strong></p>
                <code class="d-block p-2 bg-light mb-3">{{ $form->user->email }}</code>
                
                <p><strong>Identifiant (Device ID):</strong></p>
                <code class="d-block p-2 bg-light mb-3">{{ $form->user->device_id ?? 'N/A' }}</code>
                
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i> Le mot de passe a été généré lors de la création du compte.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

