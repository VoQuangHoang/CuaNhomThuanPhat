<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'phone',
        'image',
        'email',
        'google_id',
        'facebook_id',
        'password',
        'code',
        'confirmed',
        'is_aff',
        'aff_id',
        'customer_role_id',
        'created_id',
        'referral_code'
    ];

    public function Address()
    {
        return $this->hasMany(\App\Models\CustomerAddress::class, 'customer_id', 'id');
    }

    public function CustomerRole()
    {
        return $this->hasOne(\App\Models\CustomerDiscount::class, 'id', 'customer_role_id');
    }

    public function aff_click()
    {
        return $this->hasOne(\App\Models\AffClick::class, 'aff_id', 'aff_id');
    }
    public function aff_sales()
    {
        return $this->hasMany(\App\Models\AffSale::class, 'aff_id', 'aff_id');
    }

    public function CustomerOrders()
    {
        return $this->hasMany(\App\Models\Orders::class, 'customer_id', 'id');
    }

    public function CurrentMonth($id)
    {
        $data = \App\Models\Orders::where('customer_id',$id)->whereMonth('created_at', \Carbon\Carbon::now()->month)
            ->where('status', 4)->whereYear('created_at', date('Y'))->get();
        $result = $data->sum('total_price') - $data->sum('shipping_fee') - $data->sum('sale_price') - $data->sum('discount_price');
        return $result;
    }

    public function AllMonth()
    {
        $data = \App\Models\Orders::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTH(created_at) as monthname"),
            DB::raw("(SUM(total_price)) as total_price"), DB::raw("(SUM(shipping_fee)) as total_shipping"),
            DB::raw("(SUM(sale_price)) as total_sale"),DB::raw("(SUM(discount_price)) as total_discount"))
            ->where('customer_id',$this->id)->whereYear('created_at', date('Y'))->where('status', 4)
            ->groupBy('monthname')->orderBy('monthname')
            ->get();
        return $data;
    }

    public function BetweenMonth($star, $end)
    {
        $data = \App\Models\Orders::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTH(created_at) as monthname"),
            DB::raw("(SUM(total_price)) as total_price"), DB::raw("(SUM(shipping_fee)) as total_shipping"),
            DB::raw("(SUM(sale_price)) as total_sale"),DB::raw("(SUM(discount_price)) as total_discount"))
            ->where('customer_id',$this->id)->whereYear('created_at', date('Y'))->where('status', 4)
            ->groupBy('monthname')->havingRaw("monthname >= ".$star."")->havingRaw("monthname <= ".$end."")
            ->get();
        return $data;
    }

    public function BetweenMonthOldYear($star, $end)
    {
        $data = \App\Models\Orders::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTH(created_at) as monthname"),
            DB::raw("(SUM(total_price)) as total_price"), DB::raw("(SUM(shipping_fee)) as total_shipping"),
            DB::raw("(SUM(sale_price)) as total_sale"),DB::raw("(SUM(discount_price)) as total_discount"))
            ->where('customer_id',$this->id)->whereYear('created_at', date("Y",strtotime("-1 year")))->where('status', 4)
            ->groupBy('monthname')->havingRaw("monthname >= ".$star."")->havingRaw("monthname <= ".$end."")
            ->get();
        return $data;
    }

    public function ByYear()
    {
        $data = \App\Models\Orders::select(DB::raw("(COUNT(*)) as count"),DB::raw("YEAR(created_at) as year"),
            DB::raw("(SUM(total_price)) as total_price"), DB::raw("(SUM(shipping_fee)) as total_shipping"),
            DB::raw("(SUM(sale_price)) as total_sale"),DB::raw("(SUM(discount_price)) as total_discount"))
            ->where('customer_id',$this->id)->where('status', 4)->groupBy('year')->orderBy('year')->get();
        return $data;
    }
}
