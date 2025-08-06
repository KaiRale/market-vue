<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public static function store(array $data): Product
    {
        $product = Product::create($data['product']);
        ImageService::storeBatch($product, $data['images']);

        return $product;
    }

    public static function update(Product $product, array $data): Product
    {
        $product->update($data['product']);

        if(isset($data['new_images'])) {
            ImageService::storeBatch($product, $data['new_images']);
        }

        return $product->fresh();
    }
}
