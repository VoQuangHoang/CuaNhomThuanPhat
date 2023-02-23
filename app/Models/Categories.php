<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Categories extends Model
{
    use Sluggable;

    protected $table = 'categories';

    protected $fillable = [ 
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'type',
        'position',
        'active',
        'popular',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getChildCate()
    {
        return $this->where('parent_id', $this->id)->orderBy('position')->get();
    }

    public function childs() {
        return $this->hasMany('App\Models\Categories','parent_id','id') ;
    }

    public function parent() {
        return $this->hasOne('App\Models\Categories','id','parent_id') ;
    }

    public function Blogs()
    {
        return $this->hasMany('App\Models\Blogs','category_id', 'id');
    }

    public function Spa()
    {
        return $this->hasMany('App\Models\Spa','category_id', 'id');
    }

    public function Products()
    {
        return $this->belongsToMany('App\Models\Products', 'product_category', 'category_id', 'product_id');
    }
}
