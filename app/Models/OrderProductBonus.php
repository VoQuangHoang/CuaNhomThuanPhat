<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductBonus extends Model
{
    use HasFactory;

    protected $table='order_bonus_product';

    protected $fillable=[
        'order_detail_id',
        'product_id',
        'product_bonus_id',
        'qty',
    ];

    public function Product()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_bonus_id');
    }

}
