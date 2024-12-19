<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Query base para pegar tarefas do usuário
        $query = Task::query()
            ->whereHas('users', function ($query) {
                $query->where('users.id', auth()->id());
            });

        // Filtro por categoria
        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        // Filtro por status
        if (request('is_completed') !== null && request('is_completed') !== '') {
            $query->where('is_completed', request('is_completed') == '1');
        }

        $tasks = $query->latest()->get();
        $categories = auth()->user()->categories;

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
            'category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value && !auth()->user()->categories()->where('id', $value)->exists()) {
                        $fail('A categoria selecionada não pertence a você.');
                    }
                }
            ],
            'new_category' => 'nullable|string|max:255',
            'users' => 'nullable|array', // Alterado para nullable
            'users.*' => 'exists:users,id',
        ]);

        if ($request->filled('new_category')) {
            $existingCategory = auth()->user()->categories()
                ->where('name', 'LIKE', $request->input('new_category'))
                ->first();

            if ($existingCategory) {
                $validated['category_id'] = $existingCategory->id;
            } else {
                $category = auth()->user()->categories()->create([
                    'name' => $request->input('new_category'),
                ]);
                $validated['category_id'] = $category->id;
            }
        }

        $task = auth()->user()->tasks()->create($validated);

        $users = $request->input('users', []);
        if (!in_array(auth()->id(), $users)) {
            $users[] = auth()->id();
        }
        $task->users()->sync($users);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
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
            'category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value && !auth()->user()->categories()->where('id', $value)->exists()) {
                        $fail('A categoria selecionada não pertence a você.');
                    }
                }
            ],
            'is_completed' => 'boolean',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $task->update($validated);
        $task->users()->sync($request->input('users', []));

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleteda com sucesso!');
    }
}
