<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories)->resolve();

        return Inertia::render('admin/category/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->keyBy('id');
        $categoryTree = Category::buildTree($categories);

        return Inertia::render('admin/category/Create', compact('categoryTree', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $data = $request->validated();
        $category = CategoryService::store($data);

        $category = CategoryResource::make($category)->resolve();

        return back()->with('success', "Category $category[title] created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = CategoryResource::make($category)->resolve();

        return Inertia::render('admin/category/Show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category = CategoryResource::make($category)->resolve();
        $categories = Category::all()->except($category['id'])->keyBy('id');

        $categoryTree = Category::buildTree($categories);

        return Inertia::render('admin/category/Edit', compact('category', 'categories', 'categoryTree'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();

        $category = CategoryService::update($category, $data);

        $category = CategoryResource::make($category)->resolve();

        return redirect()->back()->with('success', "Category $category[title] updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('success', "Category deleted successfully");
    }
}
