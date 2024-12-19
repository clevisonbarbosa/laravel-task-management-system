<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->tasks()->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('is_completed')) {
            $query->where('is_completed', $request->is_completed);
        }

        $tasks = $query->get();

        $categories = $user->categories;

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $categories = auth()->user()->categories;
        $allUsers = \App\Models\User::all();

        return view('tasks.create', compact('categories', 'allUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        if ($request->filled('new_category')) {
            $category = auth()->user()->categories()->create([
                'name' => $request->input('new_category'),
            ]);
            $validated['category_id'] = $category->id;
        }

        $task = auth()->user()->tasks()->create($validated);
        $task->users()->sync($request->input('users', []));

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $categories = auth()->user()->categories;
        $allUsers = \App\Models\User::all();

        return view('tasks.edit', compact('task', 'categories', 'allUsers'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->merge([
            'is_completed' => $request->has('is_completed'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_completed' => 'boolean',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $task->update($validated);

        $task->users()->sync($request->input('users', []));

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
