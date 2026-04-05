<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with filtering, search and pagination.
     */
public function index(Request $request): View
{
    $tasks = Task::query()
        ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
        ->when($request->filled('search'), fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
        ->latest()
        ->paginate(5)
        ->withQueryString();

    $statusCounts = [
        'all'         => Task::count(),
        'todo'        => Task::where('status', 'todo')->count(),
        'in_progress' => Task::where('status', 'in_progress')->count(),
        'done'        => Task::where('status', 'done')->count(),
    ];

    return view('tasks.index', compact('tasks', 'statusCounts'));
}

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task.
     */
    public function store(TaskRequest $request)
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
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tâche mise à jour avec succès !');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tâche supprimée avec succès !');
    }

    /**
     * Mark task as done (bonus feature – one click).
     */
    public function markDone(Task $task)
    {
        $task->update(['status' => 'done']);

        return redirect()
            ->back()
            ->with('success', "La tâche \"{$task->title}\" est marquée comme terminée !");
    }
}
