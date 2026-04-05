@extends('layouts.app')
@section('title', 'Nouvelle tâche')

@section('content')

<div class="mb-3">
    <a href="{{ route('tasks.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">Nouvelle tâche</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            @include('tasks._form')
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Créer
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
