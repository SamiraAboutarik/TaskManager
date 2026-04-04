@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')

{{-- Breadcrumb --}}
<div class="mb-4" style="display:flex; align-items:center; gap:.5rem; color:var(--muted); font-size:.85rem;">
    <a href="{{ route('tasks.index') }}" style="color:var(--muted); text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Mes tâches
    </a>
    <span>/</span>
    <span style="color:var(--text)">Modifier</span>
</div>

<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h1 class="page-title mb-1">Modifier la tâche</h1>
        <p style="color:var(--muted); font-size:.88rem; margin:0;">
            Créée le {{ $task->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>
    {{-- Inline delete from edit page --}}
    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
          onsubmit="return confirm('Supprimer cette tâche définitivement ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-icon btn-del" style="padding:.45rem .9rem; font-size:.85rem;">
            <i class="bi bi-trash3 me-1"></i> Supprimer
        </button>
    </form>
</div>

<div class="card-surface" style="max-width: 720px;">
    <form method="POST" action="{{ route('tasks.update', $task) }}" novalidate>
        @csrf
        @method('PUT')

        @include('tasks._form')

        <div class="d-flex gap-2 mt-4 pt-3" style="border-top: 1px solid var(--border);">
            <button type="submit" class="btn-accent" style="padding:.6rem 1.5rem; font-size:.9rem;">
                <i class="bi bi-floppy me-1"></i> Enregistrer
            </button>
            <a href="{{ route('tasks.index') }}" class="btn-ghost" style="text-decoration:none; padding:.6rem 1.2rem; font-size:.9rem;">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
