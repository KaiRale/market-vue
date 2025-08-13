<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function productIndex(Category $category)
    {
        $categoryChildren = CategoryService::getCategoryChildren($category);
        $categoryBreadcrumb = CategoryResource::collection(array_reverse(CategoryService::getCategoryParents($category)))->resolve();
        $products = ProductResource::collection(ProductService::indexByCategories($categoryChildren))->resolve();
        $category = CategoryResource::make($category)->resolve();

        return inertia('client/category/ProductIndex', compact('category','products', 'categoryBreadcrumb'));
    }
}
