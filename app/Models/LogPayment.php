<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPayment extends Model
{
    use HasFactory;

    protected $table = 'log_payment';

    protected $fillable = [
        'ma_website',
        'ma_gd',
        'so_hd',
        'so_tien',
        'ngan_hang',
        'noidung_tt',
        'trang_thai',
        'ngay_tao',
        'order_id',
        'type_payment'
    ];

    public function vnPayStatus()
    {
        return $this->hasOne(\App\Models\VnpayStatus::class, 'ma_loi', 'trang_thai');
    }
}
