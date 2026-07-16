<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'productname',
        'cateid',
        'brandid',
        'slug',
        'price',
        'pricediscount',
        'image',
        'status',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['productname'] ?? null;
    }

    public function getCategoryIdAttribute()
    {
        return $this->attributes['cateid'] ?? null;
    }

    public function getBrandIdAttribute()
    {
        return $this->attributes['brandid'] ?? null;
    }

    public function getIsActiveAttribute()
    {
        return (int)($this->attributes['status'] ?? 0) === 1;
    }

    public function getDiscountAttribute()
    {
        return (float)($this->attributes['pricediscount'] ?? 0);
    }

    public function getViewsAttribute()
    {
        return (int)($this->attributes['views'] ?? 0);
    }

    public function getPrimaryImageAttribute()
    {
        $image = $this->attributes['image'] ?? null;

        if (!empty($image)) {
            return $image;
        }

        $firstImage = $this->images()->first();

        return $firstImage?->image_path ?? null;
    }
}
   