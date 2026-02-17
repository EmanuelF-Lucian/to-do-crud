<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $tasks = Auth::user()->tasks()->latest()->paginate(15);

        return Inertia::render('tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('tasks/Create', [
            'options' => TaskStatus::toSelectArrays(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {

        $validated = $request->validated();

        Auth::user()->tasks()->create($validated);

        Inertia::flash('success', 'Task created successfully.');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): \Inertia\Response
    {
        Gate::authorize('manageTask', $task);

        return Inertia::render('tasks/Show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): \Inertia\Response
    {
        Gate::authorize('manageTask', $task);

        return Inertia::render('tasks/Edit', [
            'task' => $task,
            'options' => TaskStatus::toSelectArrays(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('manageTask', $task);

        $validated = $request->validated();

        $task->update($validated);
        Inertia::flash('success', 'Task updated successfully.');

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): \Illuminate\Http\RedirectResponse
    {
        Gate::authorize('manageTask', $task);

        $task->delete();

        Inertia::flash('success', 'Task deleted successfully.');

        return redirect()->route('tasks.index');
    }
}
