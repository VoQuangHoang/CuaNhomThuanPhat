<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attributes extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'attributes';

    protected $fillable = [ 
    	'code',
        'name',
        'description',
        'is_filterable',
        'is_required'
	];

    public function sluggable(): array
    {
        return [
            'code' => [
                'source' => 'name'
            ]
        ];
    }
}
