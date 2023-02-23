<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = 'banks';
    
    protected $fillable = [ 
        'name', 'number', 'bank', 'status', 'mess'
    ];
}
