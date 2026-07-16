<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'cateid';

    protected $fillable = [
        'catename',
        'slug',
        'description',
        'image',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cateid', 'cateid');
    }

    public function getNameAttribute()
    {
        return $this->attributes['catename'] ?? null;
    }

    public function getIdAttribute()
    {
        return $this->attributes['cateid'] ?? null;
    }
}