<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public static function store(array $data): Category
    {
        return Category::create($data);
    }

    public static function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

    public static function getCategoryChildren(Category $category): array
    {
        $arr = [];

        $categoryChildren = $category->children()->get();

        foreach ($categoryChildren as $categoryChild) {
            $arr = array_merge($arr, self::getCategoryChildren($categoryChild));
        }

        $arr[] = $category;

        return $arr;
    }

    public static function getCategoryParents(Category $category): array
    {
        $arr = [];

        if  ($category->parent_id){
            $parentCategory = Category::find($category->parent_id);
            $arr[] = $parentCategory;
            $arr = array_merge($arr, self::getCategoryParents($parentCategory));
        }

        return $arr;
    }
}
