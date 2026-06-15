<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price'        => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Product $product) {
            $product->images->each(fn (ProductImage $image) => $image->delete());
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function primaryImage()
    {
        return $this->images->first();
    }
}