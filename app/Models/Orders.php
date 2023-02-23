<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table='orders';

    protected $fillable=[
        'customer_id',
        'sku',
        'payment_type',
        'name',
        'email',
        'phone',
        'address',
        'city_id',
        'district_id',
        'ward_id',
        'note',
        'total_price',
        'shipping_fee',
        'status',
        'code',
        'sale_price',
        'total_weight',
        'discount_price',
        'vtp_order_number'
    ];
    
    public function Customer()
    {
        return $this->hasOne(\App\Models\Customer::class, 'id', 'customer_id');
    }

    public function OrderDetail()
    {
    	return $this->hasMany(\App\Models\OrderDetail::class, 'order_id', 'id');
    }

    public function getStatusOrder($type,$status)
    {
        if(in_array($type, [1,2])){
            switch ($status) {
                case '1':
                    return '<span class="badge bg-warning text-dark"> Mới đặt</span>';
                    break;
                case '2':
                    return '<span class="badge bg-primary">Đã xác nhận</span>';
                    break;
                case '3':
                    return '<span class="badge bg-info text-dark"> Đang giao hàng</span>';
                    break;
                case '4':
                    return '<span class="badge bg-success"> Hoàn thành</span>';
                    break;
                case '5':
                    return '<span class="badge bg-danger">Đơn hàng bị hủy</span>';
                    break;
                case '6':
                    return '<span class="badge bg-info text-dark">Đang chờ thanh toán</span>';
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            if($status == 4){
                return '<span class="badge bg-success"> Hoàn thành</span>';
            }
            if($status != 4){
                return '<span class="badge bg-danger"> Lỗi thanh toán</span>';
            }
        }
    }

    public function byMonth(){
        return $this->whereMonth('created_at', Carbon::now()->month)->get();
    }
}
