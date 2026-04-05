@extends('layouts.app')
@section('title', 'Modifier la tâche')

@section('content')

<div class="mb-3">
    <a href="{{ route('tasks.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="card" style="max-width: 680px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Modifier la tâche</h5>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
              onsubmit="return confirm('Supprimer cette tâche ?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash3 me-1"></i> Supprimer
            </button>
        </form>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf @method('PUT')
            @include('tasks._form')
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i> Enregistrer
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
