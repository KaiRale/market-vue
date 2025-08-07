<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// linked to observer for event listening
#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Param::class)->withPivot('value');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }
}
