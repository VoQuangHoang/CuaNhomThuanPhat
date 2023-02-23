<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Products extends Model
{
    use Sluggable;

    protected $table = 'products';

    protected $fillable = [
        'sku', 'name', 'slug', 'image', 'description', 'short_desc', 'price','status',
        'more_image','brand_id', 'user_id', 'popular', 'meta_title', 'meta_description', 'meta_keyword',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function Author()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function Category()
    {
        return $this->belongsToMany('App\Models\Categories', 'product_category', 'product_id', 'category_id');
    }

    public function Reviews()
    {
        return $this->hasMany('App\Models\ProductReviews', 'product_id', 'id');
    }

    public function Brand()
    {
        return $this->hasOne('App\Models\Brands', 'id', 'brand_id');
    }
}
