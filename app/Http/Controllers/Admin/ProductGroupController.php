<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGroup\StoreRequest;
use App\Http\Requests\Admin\ProductGroup\UpdateRequest;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\ProductGroup;
use App\Services\ProductGroupService;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productGroups = ProductGroup::all();
        $productGroups = ProductGroupResource::collection($productGroups)->resolve();

        return Inertia::render('admin/product-group/Index', compact('productGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/product-group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::store($data);

        return back()->with('success', "Product group $productGroup[title] created successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return Inertia::render('admin/product-group/Show', compact('productGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup)
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();

        return Inertia::render('admin/product-group/Edit', compact('productGroup'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ProductGroup $productGroup)
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::update($productGroup, $data);

        return redirect()->back()->with('success', "Product group $productGroup[title] updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        $productGroup->delete();

        return redirect()->back()->with('success', "Product group deleted successfully");

    }
}
