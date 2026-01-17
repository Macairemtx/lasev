@extends('admin.layout')

@section('title', 'Formulaires de Confort Alimentaire')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-file-earmark-medical"></i> Formulaires de Confort Alimentaire</h1>
</div>

<div class="card">
    <div class="card-body">
        @if($forms->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Participant</th>
                            <th>Email</th>
                            <th>Plan de Retraite</th>
                            <th>Allergies</th>
                            <th>Régime</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $form)
                            <tr>
                                <td>{{ $form->id }}</td>
                                <td>
                                    <strong>{{ $form->first_name }} {{ $form->last_name }}</strong>
                                    @if($form->user)
                                        <br><small class="text-muted">User ID: {{ $form->user->id }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($form->user && $form->user->email)
                                        <code>{{ $form->user->email }}</code>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($form->retreatPlan)
                                        <span class="badge bg-info">{{ $form->retreatPlan->title }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($form->has_allergies)
                                        <span class="badge bg-danger">Oui</span>
                                        @if($form->allergy_food)
                                            <br><small>{{ Str::limit($form->allergy_food, 30) }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Non</span>
                                    @endif
                                </td>
                                <td>
                                    @if($form->specific_diets && is_array($form->specific_diets) && count($form->specific_diets) > 0)
                                        @foreach(array_slice($form->specific_diets, 0, 2) as $diet)
                                            <span class="badge bg-secondary">{{ ucfirst($diet) }}</span>
                                        @endforeach
                                        @if(count($form->specific_diets) > 2)
                                            <small>+{{ count($form->specific_diets) - 2 }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Aucun</span>
                                    @endif
                                </td>
                                <td>{{ $form->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.food-comfort-forms.show', $form) }}" class="btn btn-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.food-comfort-forms.destroy', $form) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formulaire ?');">
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
                {{ $forms->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-medical" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun formulaire de confort alimentaire soumis.</p>
            </div>
        @endif
    </div>
</div>
@endsection

