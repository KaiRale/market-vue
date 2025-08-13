<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function productIndex(Category $category)
    {
        $products = ProductResource::collection($category->products)->resolve();

        return inertia('client/category/ProductIndex', compact('products'));
    }
}
