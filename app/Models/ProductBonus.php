<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBonus extends Model
{
    use HasFactory;

    protected $table = 'product_bonus';

    protected $fillable = [
        'product_id',
        'product_bonus_id',
        'min_required',
        'bonus_quantity',
    ];

    public function Product(){
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_bonus_id');
    }
}
