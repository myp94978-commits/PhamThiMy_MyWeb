<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'proname',
        'cateid',
        'brandid',
        'slug',
        'price',
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
}