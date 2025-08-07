<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public static function store(array $data): Product
    {
        $product = Product::create($data['product']);
        ImageService::storeBatch($product, $data['images']);
        ProductService::attachBatchParams($product, $data);

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
    public static function attachBatchParams(Product $product, array $data): void
    {
        foreach ($data['params'] as $param) {
            $product->params()->attach($param['id'], [
                'value' => $param['value']
            ]);
        }
    }
}
