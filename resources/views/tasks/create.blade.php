@extends('layouts.app')

@section('title', 'Nouvelle tâche')

@section('content')

{{-- Breadcrumb --}}
<div class="mb-4" style="display:flex; align-items:center; gap:.5rem; color:var(--muted); font-size:.85rem;">
    <a href="{{ route('tasks.index') }}" style="color:var(--muted); text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Mes tâches
    </a>
    <span>/</span>
    <span style="color:var(--text)">Nouvelle tâche</span>
</div>

<h1 class="page-title mb-4">Nouvelle tâche</h1>

<div class="card-surface" style="max-width: 720px;">
    <form method="POST" action="{{ route('tasks.store') }}" novalidate>
        @csrf

        @include('tasks._form')

        <div class="d-flex gap-2 mt-4 pt-3" style="border-top: 1px solid var(--border);">
            <button type="submit" class="btn-accent" style="padding:.6rem 1.5rem; font-size:.9rem;">
                <i class="bi bi-plus-lg me-1"></i> Créer la tâche
            </button>
            <a href="{{ route('tasks.index') }}" class="btn-ghost" style="text-decoration:none; padding:.6rem 1.2rem; font-size:.9rem;">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection
