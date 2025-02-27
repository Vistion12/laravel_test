<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $categories = $this->categoryService->getAllCategories(10); // 10 - количество категорий на странице

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category
        ]);
    }
}
