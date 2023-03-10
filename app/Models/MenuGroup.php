<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;

    protected $table = 'menu_group';

    protected $fillable = [ 'title','position'];
}
