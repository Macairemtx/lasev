@extends('admin.layout')

@section('title', 'Détails du Plan de Retraite')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-calendar-check"></i> Détails du Plan de Retraite</h1>
    <div>
        <a href="{{ route('admin.retreat-plans.edit', $plan) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('admin.retreat-plans.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $plan->id }}</td>
                    </tr>
                    <tr>
                        <th>Titre</th>
                        <td><strong>{{ $plan->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $plan->description }}</td>
                    </tr>
                    <tr>
                        <th>Durée</th>
                        <td>{{ $plan->duration_days }} jour(s)</td>
                    </tr>
                    <tr>
                        <th>Prix</th>
                        <td>
                            @if($plan->price)
                                {{ number_format($plan->price, 2) }} €
                            @else
                                <span class="text-muted">Gratuit</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Statut</th>
                        <td>
                            @if($plan->status === 'available')
                                <span class="badge bg-success">Disponible</span>
                            @elseif($plan->status === 'on_request')
                                <span class="badge bg-warning">Sur demande</span>
                            @else
                                <span class="badge bg-info">Bientôt</span>
                            @endif
                        </td>
                    </tr>
                    @if(is_array($plan->features) && count($plan->features) > 0)
                        <tr>
                            <th>Caractéristiques</th>
                            <td>
                                @foreach($plan->features as $feature)
                                    <span class="badge bg-primary me-1">{{ $feature }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(is_array($plan->tags) && count($plan->tags) > 0)
                        <tr>
                            <th>Tags</th>
                            <td>
                                @foreach($plan->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(is_array($plan->services) && count($plan->services) > 0)
                        <tr>
                            <th>Services</th>
                            <td>
                                @foreach($plan->services as $service)
                                    <span class="badge bg-info me-1">{{ $service }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Créé le</th>
                        <td>{{ $plan->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Modifié le</th>
                        <td>{{ $plan->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @if($plan->cover_image)
                    <img src="{{ asset('storage/' . $plan->cover_image) }}" 
                         alt="{{ $plan->title }}" 
                         style="width: 100%; height: auto; border-radius: 8px;">
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-image" style="font-size: 64px; color: #ccc;"></i>
                        <p class="text-muted mt-2">Aucune image</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

