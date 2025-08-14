<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Param;
use App\Services\CategoryService;
use App\Services\ParamService;
use App\Services\ProductService;

class CategoryController extends Controller
{
    public function productIndex(Category $category)
    {
        $categoryChildren = CategoryService::getCategoryChildren($category);

        $params = ParamService::indexByCategories($categoryChildren);
        $params = ParamWithValuesResource::collection($params)->resolve();

        $categoryBreadcrumb = CategoryResource::collection(CategoryService::getCategoryParents($category))->resolve();
        $products = ProductResource::collection(ProductService::indexByCategories($categoryChildren))->resolve();
        $category = CategoryResource::make($category)->resolve();

        return inertia('client/category/ProductIndex', compact('category','products', 'categoryBreadcrumb', 'params'));
    }
}
