<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = 'customer_address';

    protected $fillable = ['customer_id','phone','name','address','city_id','district_id','ward_id','type','is_default'];

    public function Ward()
    {
        return $this->hasOne(\App\Models\Ward::class, 'id', 'ward_id');
    }

}
