{{-- Reusable form used for Create and Edit --}}
<div class="row g-4">

    {{-- Title --}}
    <div class="col-12">
        <label class="form-label" for="title">
            Titre <span style="color:var(--danger)">*</span>
        </label>
        <input
            type="text"
            id="title"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="Ex : Configurer la base de données"
            value="{{ old('title', $task->title ?? '') }}"
            autofocus
        >
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Description --}}
    <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea
            id="description"
            name="description"
            class="form-control @error('description') is-invalid @enderror"
            rows="4"
            placeholder="Détails de la tâche (optionnel)…"
        >{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-6">
        <label class="form-label" for="status">
            Statut <span style="color:var(--danger)">*</span>
        </label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="">-- Choisir un statut --</option>
            <option value="todo"        {{ old('status', $task->status ?? '') === 'todo'        ? 'selected' : '' }}>À faire</option>
            <option value="in_progress" {{ old('status', $task->status ?? '') === 'in_progress' ? 'selected' : '' }}>En cours</option>
            <option value="done"        {{ old('status', $task->status ?? '') === 'done'        ? 'selected' : '' }}>Terminé</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Due date --}}
    <div class="col-md-6">
        <label class="form-label" for="due_date">Date d'échéance</label>
        <input
            type="date"
            id="due_date"
            name="due_date"
            class="form-control @error('due_date') is-invalid @enderror"
            value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
        >
        @error('due_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
