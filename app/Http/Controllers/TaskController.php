<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $q = $request->string('q')->toString();

        $tasksQuery = Task::query();

        if (in_array($status, ['pending', 'done'], true)) {
            $tasksQuery->where('status', $status);
        }

        if ($q !== '') {
            $tasksQuery->where(function ($query) use ($q) {
                $query
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $tasks = $tasksQuery
            ->orderBy('deadline')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('tasks.index', [
            'tasks' => $tasks,
            'status' => $status,
            'q' => $q,
        ]);
    }

    public function create()
    {
        return view('tasks.create', [
            'task' => new Task(['status' => 'pending']),
        ]);
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = $validated['status'] ?? 'pending';

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        $task->update([
            'status' => $task->status === 'done' ? 'pending' : 'done',
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'id' => $task->id,
                'status' => $task->status,
                'deadline' => $task->deadline->format('Y-m-d'),
            ]);
        }

        return back()->with('success', 'Task status updated.');
    }
}
