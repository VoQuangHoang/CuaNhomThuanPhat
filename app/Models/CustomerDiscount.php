<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDiscount extends Model
{
    use HasFactory;

    protected $table = 'customer_discount';

    protected $fillable = [
        'name',
        'discount',
        'level',
        'condition_apply',
        'quantity_apply'
    ];
}
