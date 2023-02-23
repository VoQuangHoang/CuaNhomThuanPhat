<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffRequest extends Model
{
    use HasFactory;

    protected $table = 'aff_request';
    
    protected $fillable = [ 
        'aff_id',
        'amount',
        'bank_name',
        'bank_number',
        'holder_name',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'aff_id', 'aff_id');
    }
}
