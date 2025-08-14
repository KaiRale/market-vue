<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public static function buildTree($elements, $parentId = null)
    {
        $branch = collect();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = self::buildTree($elements, $element->id);
                if ($children->isNotEmpty()) {
                    $element->children = $children;
                }
                $branch->push($element);
            }
        }
        return $branch;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function paramProducts(): HasManyThrough
    {
        return $this->hasManyThrough(
            ParamProduct::class,
            Product::class,
            'category_id',
            'product_id',
            'id',
            'id');
    }
}
