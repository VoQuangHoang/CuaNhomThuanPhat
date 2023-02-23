<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffClick extends Model
{
    use HasFactory;

    protected $table = 'aff_clicks';
    
    protected $fillable = [ 
        'aff_id',
        'click_count'
    ];
}
