<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories;
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = auth()->user()->categories()->create($validated);

        return redirect()->back()->with('success', 'Categoria criada com sucesso!');
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->back()->with('success', 'Categoria excluída com sucesso!');
    }
}
