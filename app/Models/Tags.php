<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $table = 'tags';
    
    protected $fillable = [ 
        'name',
        'slug',
        'type',
        'description'
    ];

    public function BlogTag()
    {
        return $this->belongsToMany('App\Models\Blogs', 'blog_tag', 'tag_id', 'blog_id');
    }
}
