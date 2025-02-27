<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

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
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->categoryService->createCategory($validated);
            return redirect()->route('admin.categories.index')->with('success', 'Категория успешно добавлена!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.create')->with('error', 'Ошибка добавления категории: ' . $e->getMessage());
        }
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        if ($this->categoryService->updateCategory($category, $validated)) {
            return redirect()->route('admin.categories.index')->with('success', 'Категория успешно изменена!');
        }

        return back()->with('error', 'Ошибка изменения категории');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($this->categoryService->deleteCategory($category)) {
            return redirect()->route('admin.categories.index')->with('success', 'Категория успешно удалена!');
        }

        return back()->with('error', 'Невозможно удалить категорию, так как она содержит посты.');
    }
}
