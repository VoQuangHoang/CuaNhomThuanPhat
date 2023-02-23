<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'payment_name',
        'url_pay',
        'vnp_TmnCode',
        'vnp_HashSecret',
        'partnercode',
        'accesskey',
        'secretkey',
        'status',
        'type',
        'production_test'
    ];
}
