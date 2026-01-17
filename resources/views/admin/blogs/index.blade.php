@extends('admin.layout')

@section('title', 'Gestion des Blogs')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-journal-text"></i> Gestion des Blogs</h1>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvel article
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($blogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Auteur</th>
                            <th>Premium</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td><strong>{{ $blog->title }}</strong></td>
                                <td>
                                    @if($blog->category)
                                        @if($blog->category === 'pouvoir-secret')
                                            <span class="badge bg-info">Le pouvoir secret</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('-', ' ', $blog->category)) }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-light text-dark">Général</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->author)
                                        {{ $blog->author->name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->is_premium)
                                        <span class="badge bg-warning">Premium</span>
                                    @else
                                        <span class="badge bg-success">Gratuit</span>
                                    @endif
                                </td>
                                <td>{{ $blog->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
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
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-journal-text" style="font-size: 64px; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun article de blog trouvé.</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer un article
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

