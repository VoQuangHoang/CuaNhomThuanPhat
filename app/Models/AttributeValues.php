<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValues extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';
    
    protected $fillable = [ 
    	'attribute_id',
        'value'
	];

    public function Attributes(){
        return $this->hasOne(\App\Models\Attributes::class, 'id', 'attribute_id');
    }
}
