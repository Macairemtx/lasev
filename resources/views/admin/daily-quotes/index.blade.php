@extends('admin.layout')

@section('title', 'Gestion des Phrases du Jour')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-quote"></i> Gestion des Phrases du Jour</h1>
    <a href="{{ route('admin.daily-quotes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle phrase du jour
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($quotes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Phrase 1 (00h-12h)</th>
                            <th>Phrase 2 (12h-23h)</th>
                            <th>Phrase 3 (23h)</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotes as $quote)
                            <tr>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}</strong>
                                    @if(\Carbon\Carbon::parse($quote->quote_date)->isToday())
                                        <span class="badge bg-success">Aujourd'hui</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($quote->quote_1, 50) }}</td>
                                <td>{{ Str::limit($quote->quote_2, 50) }}</td>
                                <td>{{ Str::limit($quote->quote_3, 50) }}</td>
                                <td>
                                    @if($quote->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.daily-quotes.edit', $quote) }}" class="btn btn-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.daily-quotes.destroy', $quote) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette phrase du jour ?');">
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
                {{ $quotes->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-quote" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune phrase du jour configurée.</p>
                <a href="{{ route('admin.daily-quotes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer la première phrase du jour
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

