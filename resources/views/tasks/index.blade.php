@extends('layouts.app')

@section('title', 'Mes Tâches')

@section('content')

{{-- Page header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="page-title">Mes tâches</h1>
    <a href="{{ route('tasks.create') }}" class="btn-accent" style="text-decoration:none; padding:.55rem 1.3rem; border-radius:8px; font-weight:600; font-size:.9rem;">
        <i class="bi bi-plus-lg me-1"></i> Ajouter
    </a>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    @php
        $filters = [
            ''           => ['label' => 'Total',     'num' => $statusCounts['all'],         'color' => '#e8e9ef'],
            'todo'       => ['label' => 'À faire',   'num' => $statusCounts['todo'],         'color' => '#f59e0b'],
            'in_progress'=> ['label' => 'En cours',  'num' => $statusCounts['in_progress'],  'color' => '#3b82f6'],
            'done'       => ['label' => 'Terminé',   'num' => $statusCounts['done'],         'color' => '#22c55e'],
        ];
    @endphp

    @foreach($filters as $value => $info)
        @php
            $isActive = request('status', '') === $value;
            $href = $value === ''
                ? route('tasks.index', request()->only('search'))
                : route('tasks.index', array_merge(request()->only('search'), ['status' => $value]));
        @endphp
        <div class="col-6 col-md-3">
            <a href="{{ $href }}" class="stat-card {{ $isActive ? 'active' : '' }}" style="text-decoration:none;">
                <div class="stat-num" style="color: {{ $info['color'] }}">{{ $info['num'] }}</div>
                <div class="stat-label">{{ $info['label'] }}</div>
            </a>
        </div>
    @endforeach
</div>

{{-- Filter + Search bar --}}
<form method="GET" action="{{ route('tasks.index') }}" class="filter-bar mb-4">
    {{-- preserve status filter --}}
    @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif

    <div class="row g-2 align-items-center">
        <div class="col">
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:.85rem;"></i>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Rechercher par titre…"
                    value="{{ request('search') }}"
                    style="padding-left: 2.2rem;"
                >
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-accent" style="border-radius:8px; padding:.55rem 1.1rem; font-size:.88rem;">
                <i class="bi bi-funnel me-1"></i> Filtrer
            </button>
        </div>
        @if(request()->hasAny(['search', 'status']))
            <div class="col-auto">
                <a href="{{ route('tasks.index') }}" class="btn-ghost" style="padding:.55rem 1rem; font-size:.85rem; text-decoration:none; display:inline-block;">
                    <i class="bi bi-x me-1"></i> Effacer
                </a>
            </div>
        @endif
    </div>
</form>

{{-- Tasks table --}}
<div class="card-surface p-0" style="overflow:hidden;">
    @if($tasks->count() > 0)
        <div style="overflow-x:auto;">
            <table class="task-table">
                <thead>
                    <tr>
                        <th style="width:40%">Tâche</th>
                        <th>Statut</th>
                        <th class="hide-mobile">Échéance</th>
                        <th class="hide-mobile">Créée le</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>
                                <div class="task-title {{ $task->status === 'done' ? 'done-title' : '' }}">
                                    {{ $task->title }}
                                    @if($task->isOverdue())
                                        <span class="overdue-badge"><i class="bi bi-exclamation-circle"></i> En retard</span>
                                    @endif
                                </div>
                                @if($task->description)
                                    <div class="task-desc">{{ Str::limit($task->description, 80) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-status {{ $task->statusColor() }}">
                                    @if($task->status === 'todo') <i class="bi bi-circle"></i>
                                    @elseif($task->status === 'in_progress') <i class="bi bi-arrow-repeat"></i>
                                    @else <i class="bi bi-check-circle-fill"></i>
                                    @endif
                                    {{ $task->statusLabel() }}
                                </span>
                            </td>
                            <td class="hide-mobile" style="color:var(--muted); font-size:.85rem;">
                                @if($task->due_date)
                                    <span style="{{ $task->isOverdue() ? 'color: var(--danger)' : '' }}">
                                        {{ $task->due_date->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span style="color:var(--muted); opacity:.4">—</span>
                                @endif
                            </td>
                            <td class="hide-mobile" style="color:var(--muted); font-size:.85rem;">
                                {{ $task->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    {{-- Mark as done --}}
                                    @if($task->status !== 'done')
                                        <form method="POST" action="{{ route('tasks.done', $task) }}" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-icon btn-done" title="Marquer terminé">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn-icon btn-edit" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;"
                                          onsubmit="return confirm('Supprimer cette tâche ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-del" title="Supprimer">
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
            <div class="d-flex justify-content-between align-items-center px-3 py-3" style="border-top: 1px solid var(--border);">
                <span style="color:var(--muted); font-size:.82rem;">
                    {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} sur {{ $tasks->total() }} tâches
                </span>
                {{ $tasks->links() }}
            </div>
        @endif

    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Aucune tâche trouvée.</p>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('tasks.index') }}" class="btn-ghost mt-3" style="display:inline-block; text-decoration:none;">
                    Voir toutes les tâches
                </a>
            @else
                <a href="{{ route('tasks.create') }}" class="btn-accent mt-3" style="display:inline-block; text-decoration:none; padding:.5rem 1.2rem; border-radius:8px;">
                    Créer ma première tâche
                </a>
            @endif
        </div>
    @endif
</div>

@endsection
