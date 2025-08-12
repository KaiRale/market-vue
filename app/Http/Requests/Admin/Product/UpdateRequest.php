<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'product.title' => 'required|string|max:255',
            'product.description' => 'required|string',
            'product.content' => 'required|string',
            'product.article' => 'required|string|max:255|unique:products,article,' . $productId,
            'product.price' => 'required|numeric',
            'product.old_price' => 'required|numeric',
            'product.qty' => 'required|integer',
            'product.category_id' => 'required|integer|exists:categories,id',
            'product.product_group_id' => 'required|integer|exists:product_groups,id',
            'images' => 'nullable|array',
            'images.*' => 'integer|exists:images,id',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'params' => 'nullable|array',
            'params.*.id' => 'required|integer|exists:params,id',
            'params.*.value' => 'required|string',
        ];
    }

    protected function passedValidation()
    {
        $validated = $this->validated();

        return $this->merge([
            'product' => $validated['product'],
            'images' => $this->images ?? [],
            'params' => $validated['params'],
        ]);
    }
}
