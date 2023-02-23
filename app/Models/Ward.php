<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'lc_ward';

    protected $fillable = ['name','slug','code', 'type', 'name_with_type', 'path', 'path_with_type', 'parent_code', 'district_id'];
}
