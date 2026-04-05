@extends('layouts.app')
@section('title', 'Liste des tâches')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Liste des tâches</h4>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nouvelle tâche
    </a>
</div>

{{-- Compteurs statut --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('tasks.index') }}" class="text-decoration-none">
            <div class="card text-center {{ !request('status') ? 'border-primary' : '' }}">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold">{{ $statusCounts['all'] }}</div>
                    <div class="text-muted small">Toutes</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('tasks.index', ['status' => 'todo']) }}" class="text-decoration-none">
            <div class="card text-center {{ request('status') === 'todo' ? 'border-warning' : '' }}">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-warning">{{ $statusCounts['todo'] }}</div>
                    <div class="text-muted small">À faire</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}" class="text-decoration-none">
            <div class="card text-center {{ request('status') === 'in_progress' ? 'border-primary' : '' }}">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-primary">{{ $statusCounts['in_progress'] }}</div>
                    <div class="text-muted small">En cours</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('tasks.index', ['status' => 'done']) }}" class="text-decoration-none">
            <div class="card text-center {{ request('status') === 'done' ? 'border-success' : '' }}">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-success">{{ $statusCounts['done'] }}</div>
                    <div class="text-muted small">Terminées</div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Barre de recherche --}}
<form method="GET" action="{{ route('tasks.index') }}" class="card mb-4">
    <div class="card-body">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="row g-2">
            <div class="col">
                <input type="text" name="search" class="form-control"
                    placeholder="Rechercher par titre..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Rechercher
                </button>
            </div>
            @if(request()->hasAny(['search', 'status']))
                <div class="col-auto">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i> Effacer
                    </a>
                </div>
            @endif
        </div>
    </div>
</form>

{{-- Tableau des tâches --}}
<div class="card">
    <div class="card-body p-0">
        @if($tasks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Titre</th>
                            <th>Statut</th>
                            <th>Échéance</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>
                                    <div class="{{ $task->status === 'done' ? 'text-decoration-line-through text-muted' : 'fw-medium' }}">
                                        {{ $task->title }}
                                        @if($task->isOverdue())
                                            <span class="badge bg-danger ms-1">En retard</span>
                                        @endif
                                    </div>
                                    @if($task->description)
                                        <div class="text-muted small">{{ Str::limit($task->description, 80) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($task->status === 'todo')
                                        <span class="badge bg-warning text-dark">À faire</span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="badge bg-primary">En cours</span>
                                    @else
                                        <span class="badge bg-success">Terminé</span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ $task->due_date ? $task->due_date->format('d/m/Y') : '—' }}
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">

                                        {{-- Marquer comme terminé --}}
                                        @if($task->status !== 'done')
                                            <form method="POST" action="{{ route('tasks.done', $task) }}">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-success" title="Marquer terminé">
                                                    <i class="bi bi-check2"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Modifier --}}
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Supprimer --}}
                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                              onsubmit="return confirm('Supprimer cette tâche ?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($tasks->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                    <span class="text-muted small">
                        {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} sur {{ $tasks->total() }} tâches
                    </span>
                    {{ $tasks->links() }}
                </div>
            @endif

        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>Aucune tâche trouvée.</p>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">Créer une tâche</a>
            </div>
        @endif
    </div>
</div>

@endsection
