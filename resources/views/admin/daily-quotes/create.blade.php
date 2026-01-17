@extends('admin.layout')

@section('title', 'Nouvelle Phrase du Jour')

@section('content')
<div class="content-header">
    <h1><i class="bi bi-quote"></i> Nouvelle Phrase du Jour</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.daily-quotes.store') }}" method="POST">
            @csrf
            
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i>
                <strong>Information :</strong> Les phrases changent 3 fois par jour selon l'heure :
                <ul class="mb-0 mt-2">
                    <li><strong>Phrase 1 :</strong> Affichée de 00:00 à 11:59</li>
                    <li><strong>Phrase 2 :</strong> Affichée de 12:00 à 22:59</li>
                    <li><strong>Phrase 3 :</strong> Affichée à 23:00</li>
                </ul>
            </div>
            
            <div class="mb-3">
                <label for="quote_date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('quote_date') is-invalid @enderror" 
                       id="quote_date" name="quote_date" value="{{ old('quote_date', date('Y-m-d')) }}" required>
                @error('quote_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quote_1" class="form-label">Phrase 1 (00:00 - 11:59) <span class="text-danger">*</span></label>
                <textarea class="form-control @error('quote_1') is-invalid @enderror" 
                          id="quote_1" name="quote_1" rows="2" required>{{ old('quote_1', 'La paix intérieure commence par le sourire de l\'âme.') }}</textarea>
                @error('quote_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quote_2" class="form-label">Phrase 2 (12:00 - 22:59) <span class="text-danger">*</span></label>
                <textarea class="form-control @error('quote_2') is-invalid @enderror" 
                          id="quote_2" name="quote_2" rows="2" required>{{ old('quote_2', 'Chaque jour est une nouvelle opportunité de grandir.') }}</textarea>
                @error('quote_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quote_3" class="form-label">Phrase 3 (23:00) <span class="text-danger">*</span></label>
                <textarea class="form-control @error('quote_3') is-invalid @enderror" 
                          id="quote_3" name="quote_3" rows="2" required>{{ old('quote_3', 'La gratitude transforme ce que nous avons en suffisance.') }}</textarea>
                @error('quote_3')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Activer cette phrase du jour
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.daily-quotes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Créer la phrase du jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

