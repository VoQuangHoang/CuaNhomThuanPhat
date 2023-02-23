<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'lc_city';

    protected $fillable = ['name','slug','code', 'type', 'name_with_type'];

    public function District() {
        return $this->hasMany('App\Models\District', 'city_id', 'id');
    }
}
