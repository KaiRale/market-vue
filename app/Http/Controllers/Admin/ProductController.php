<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Category;
use App\Models\Param;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Services\ProductService;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::whereNull('parent_id')->get();
        $products = ProductResource::collection($products)->resolve();

        return Inertia::render('admin/product/Index', compact('products'));
    }

    public function indexChild(Product $product)
    {
        return ProductResource::collection($product->children)->resolve();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->keyBy('id');
        $categoryTree = Category::buildTree($categories);
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();

        return Inertia::render('admin/product/Create', compact(
            'categories',
            'categoryTree',
            'productGroups',
            'params'
        ));
    }

    public function createChild(Product $product)
    {
        $categories = Category::all()->keyBy('id');
        $categoryTree = Category::buildTree($categories);
        $productGroups = ProductGroupResource::collection(ProductGroup::all())->resolve();
        $params = ParamResource::collection(Param::all())->resolve();
        $product = ProductResource::make($product)->resolve();

        return Inertia::render('admin/product/CreateChild', compact(
            'categories',
            'categoryTree',
            'productGroups',
            'params',
            'product'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $product = ProductService::store($data);

        return back()->with('success', "Product $product[title] created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = ProductResource::make($product)->resolve();

        return Inertia::render('admin/product/Show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = ProductResource::make($product)->resolve();
        $categories = Category::all()->keyBy('id');
        $categoryTree = Category::buildTree($categories);
        $productGroups = ProductGroup::all()->keyBy('id');
        $params = ParamResource::collection(Param::all())->resolve();

        return Inertia::render('admin/product/Edit', compact(
            'product',
            'categories',
            'categories',
            'categoryTree',
            'productGroups',
            'params'
        ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validationData();
        $product = ProductService::update($product, $data);

        return response()->json([
            'product' => ProductResource::make($product)->resolve(),
            'success' => "Product $product[title] updated successfully"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'product' => ProductResource::make($product)->resolve(),
            'success' => "Product deleted successfully"
        ]);
//        back()->with('success', "Product deleted successfully");

    }
}
