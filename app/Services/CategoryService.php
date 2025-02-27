<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function getAllCategories($paginate = 5)
    {
        return Category::query()->paginate($paginate);
    }

    public function createCategory(array $data)
    {
        try {
            return Category::create($data);
        } catch (\Exception $e) {
            Log::error('Ошибка при создании категории: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->fill($data);
        if ($category->save()) {
            return true;
        }
        return false;
    }

    public function deleteCategory(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return false;
        }
        return $category->delete();
    }
}
