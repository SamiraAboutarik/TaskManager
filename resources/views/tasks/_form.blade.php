{{-- Titre --}}
<div class="mb-3">
    <label for="title" class="form-label fw-medium">Titre <span class="text-danger">*</span></label>
    <input type="text" id="title" name="title"
        class="form-control @error('title') is-invalid @enderror"
        placeholder="Ex : Configurer la base de données"
        value="{{ old('title', $task->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Description --}}
<div class="mb-3">
    <label for="description" class="form-label fw-medium">Description</label>
    <textarea id="description" name="description" rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Détails de la tâche (optionnel)">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Statut --}}
<div class="mb-3">
    <label for="status" class="form-label fw-medium">Statut <span class="text-danger">*</span></label>
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

{{-- Date d'échéance --}}
<div class="mb-3">
    <label for="due_date" class="form-label fw-medium">Date d'échéance</label>
    <input type="date" id="due_date" name="due_date"
        class="form-control @error('due_date') is-invalid @enderror"
        value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
    @error('due_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
