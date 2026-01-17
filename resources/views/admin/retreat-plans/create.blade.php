@extends('admin.layout')

@section('title', 'Nouveau Plan de Retraite')

@section('content')
<div class="content-header">
    <h1><i class="bi bi-calendar-check"></i> Nouveau Plan de Retraite</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.retreat-plans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_days" class="form-label">Durée (jours) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration_days') is-invalid @enderror" 
                                       id="duration_days" name="duration_days" value="{{ old('duration_days') }}" min="1" required>
                                @error('duration_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" min="0">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="on_request" {{ old('status') === 'on_request' ? 'selected' : '' }}>Sur demande</option>
                            <option value="coming_soon" {{ old('status') === 'coming_soon' ? 'selected' : '' }}>Bientôt disponible</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="features" class="form-label">Caractéristiques (séparées par des virgules)</label>
                        <input type="text" class="form-control" id="features" name="features" 
                               value="{{ old('features') }}" placeholder="ex: Hébergement, Repas, Méditation guidée">
                        <small class="form-text text-muted">Exemple: Hébergement, Repas, Méditation guidée, Yoga</small>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (séparés par des virgules)</label>
                        <input type="text" class="form-control" id="tags" name="tags" 
                               value="{{ old('tags') }}" placeholder="ex: retraite, méditation, bien-être">
                    </div>

                    <div class="mb-3">
                        <label for="services" class="form-label">Services (séparés par des virgules)</label>
                        <input type="text" class="form-control" id="services" name="services" 
                               value="{{ old('services') }}" placeholder="ex: Spa, Piscine, Restaurant">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Image de couverture</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                               id="cover_image" name="cover_image" accept="image/*">
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG, GIF (max 2MB)</small>
                    </div>

                    <div id="image-preview" class="mb-3" style="display: none;">
                        <img id="preview-img" src="" alt="Aperçu" 
                             style="width: 100%; height: auto; border-radius: 8px; max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.retreat-plans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Créer le plan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection

