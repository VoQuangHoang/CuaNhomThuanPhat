<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table='order_detail';

    protected $fillable=[
        'order_id',
        'product_id',
        'price',
        'point',
        'qty',
        'total_price',
        'product_attribute_id',
    ];

    public function Product()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_id');
    }

    public function OrderBonusProduct(){
        return $this->hasMany(\App\Models\OrderProductBonus::class, 'order_detail_id', 'id');
    }
}
