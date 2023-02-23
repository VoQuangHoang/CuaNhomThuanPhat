<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blogs extends Model
{
    use Sluggable;

    protected $table = 'blogs';

    protected $fillable = [ 
        'title',
        'slug',
        'short_desc',
        'content',
        'image',
        'category_id',
        'status',
        'created_by',
        'updated_by',
        'view',
        'meta_title',
        'meta_description',
        'meta_keyword'
	];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function Creator()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'created_by');
    }

    public function Editor()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'updated_by');
    }

    public function Category()
    {
        return $this->hasOne(\App\Models\Categories::class, 'id', 'category_id');
    }

    public function Tags()
    {
        return $this->belongsToMany('App\Models\Tags', 'blog_tag', 'blog_id', 'tag_id');
    }
}
