<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductParent\StoreRequest;
use App\Http\Requests\Admin\ProductParent\UpdateRequest;
use App\Http\Resources\ProductParent\ProductParentResource;
use App\Models\ProductParent;
use App\Services\ProductParentService;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ProductParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productParents = ProductParent::all();
        $productParents = ProductParentResource::collection($productParents)->resolve();

        return Inertia::render('admin/product-parent/Index', compact('productParents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/product-parent/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $productParent = ProductParentService::store($data);

        // resolve - чтобы дополнительно не оборачиволось в ключ дата
        return ProductParentResource::make($productParent)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductParent $productParent)
    {
        $productParent = ProductParentResource::make($productParent)->resolve();

        return Inertia::render('admin/product-parent/Show', compact('productParent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductParent $productParent)
    {
        $productParent = ProductParentResource::make($productParent)->resolve();

        return Inertia::render('admin/product-parent/Edit', compact('productParent'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ProductParent $productParent)
    {
        $data = $request->validated();
        $productParent = ProductParentService::update($productParent, $data);

        // resolve - чтобы дополнительно не оборачиволось в ключ дата
        return ProductParentResource::make($productParent)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductParent $productParent)
    {
        $productParent->delete();

        return response()->json([
            'message' => 'ProductParent deleted successfully'
        ], Response::HTTP_OK);
    }
}
