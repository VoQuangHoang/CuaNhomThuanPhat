<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';
    
    protected $fillable = [
        'type',
        'name_page',
        'route',
        'content',
        'image',
        'banner',
        'meta_title',
        'meta_description',
        'meta_keyword'];
}
