<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->paginate(5);

        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255|unique:categories,name'
        ]);

        try {
            $category = Category::create($validated);
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.create')->with('error', 'Ошибка добавления категории: ' . $e->getMessage());
        }

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255|unique:categories,name,' . $category->id
        ]);

        $category->fill($validated);

        if ($category->save()) {
            return redirect()->route('admin.categories.index')->with('success', 'Категория успешно изменена!');
        }

        return back()->with('error', 'Ошибка изменения категории');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Невозможно удалить категорию, так как она содержит посты.');
        }

        if ($category->delete()) {
            return redirect()->route('admin.categories.index')->with('success', 'Категория успешно удалена!');
        }

        return back()->with('error', 'Ошибка удаления категории');
    }
}
