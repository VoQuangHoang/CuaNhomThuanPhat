<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brands extends Model
{
    use Sluggable;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
