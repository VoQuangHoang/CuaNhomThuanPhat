<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffSale extends Model
{
    use HasFactory;

    protected $table = 'aff_sales';
    
    protected $fillable = [ 
        'aff_id',
        'order_id',
        'total_amount',
        'aff_amount',
        'status',
        'withdraw',
        'type'
    ];

    public function order()
    {
        return $this->hasOne(Orders::class, 'id', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'aff_id', 'aff_id');
    }
}
