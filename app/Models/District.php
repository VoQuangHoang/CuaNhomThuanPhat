<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'lc_district';

    protected $fillable = ['name','slug','code', 'type', 'name_with_type', 'path', 'path_with_type', 'parent_code', 'city_id'];

    public function Ward() {
        return $this->hasMany('App\Models\Ward', 'district_id', 'id');
    }
}
