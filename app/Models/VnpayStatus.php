<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VnpayStatus extends Model
{
    use HasFactory;

    protected $table = 'vnpay_status';

    protected $fillable = ['ma_loi','mo_ta'];
}
