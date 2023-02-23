<?php

namespace App\Observers;

use session;
use App\Models\Orders;
use App\Models\AffSale;
use App\Models\Customer;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class OrderObserver
{
    /**
     * Handle the Orders "created" event.
     *
     * @param  \App\Models\Orders  $orders
     * @return void
     */
    public function created(Orders $orders)
    {
        $options = Settings::where('type', 'affiliate')->first();
        $aff_setting = json_decode(@$options->content);
        $ck_ctv = !empty($aff_setting->affiliate) ? $aff_setting->affiliate : 0;
        $aff_id = Cookie::get('affId');
        $customer = Customer::where('aff_id', $aff_id)->first();

        $referral_code = session()->get('referral');
        $customer2 = Customer::where('referral_code', $referral_code)->first();

        if($aff_id){
            $type = 1;
        }elseif($referral_code){
            $type = 2;
        }
        
        
        if (($aff_id && $customer) || ($referral_code && $customer2)) {
            if (Auth::guard('customer')->user()->aff_id != $aff_id || Auth::guard('customer')->user()->referral_code != $referral_code) {
                AffSale::create([
                    'aff_id' => $aff_id ?? $customer2->aff_id,
                    'order_id' => $orders->id,
                    'total_amount' => $orders->total_price,
                    'aff_amount' => $orders->total_price * ($ck_ctv/100),
                    'type' => $type
                ]);
            }
        }
    }

    /**
     * Handle the Orders "updated" event.
     *
     * @param  \App\Models\Orders  $orders
     * @return void
     */
    public function updated(Orders $orders)
    {
        $aff_sale = AffSale::where('order_id', $orders->id)->first();
        if ($aff_sale) {
            if ($orders->status == 4) {
                $aff_sale->status = 1;
            } else {
                $aff_sale->status = 0;
            }
            $aff_sale->save();
        }
    }

    /**
     * Handle the Orders "deleted" event.
     *
     * @param  \App\Models\Orders  $orders
     * @return void
     */
    public function deleted(Orders $orders)
    {
        //
    }

    /**
     * Handle the Orders "restored" event.
     *
     * @param  \App\Models\Orders  $orders
     * @return void
     */
    public function restored(Orders $orders)
    {
        //
    }

    /**
     * Handle the Orders "force deleted" event.
     *
     * @param  \App\Models\Orders  $orders
     * @return void
     */
    public function forceDeleted(Orders $orders)
    {
        //
    }
}
