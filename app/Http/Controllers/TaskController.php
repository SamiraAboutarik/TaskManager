<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with filtering, search and pagination.
     */
    public function index(Request $request): View
    {
        $query = Task::query()->latest();

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['todo', 'in_progress', 'done'])) {
            $query->byStatus($request->status);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tasks = $query->paginate(5);

        $statusCounts = [
            'all'         => Task::count(),
            'todo'        => Task::byStatus('todo')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'done'        => Task::byStatus('done')->count(),
        ];

        return view('tasks.index', compact('tasks', 'statusCounts'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task.
     */
    public function store(TaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tâche créée avec succès !');
    }

    /**
     * Show the form for editing a task.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task.
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tâche mise à jour avec succès !');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tâche supprimée avec succès !');
    }

    /**
     * Mark task as done (bonus feature – one click).
     */
    public function markDone(Task $task): RedirectResponse
    {
        $task->update(['status' => 'done']);

        return redirect()
            ->back()
            ->with('success', "La tâche \"{$task->title}\" est marquée comme terminée !");
    }
}
