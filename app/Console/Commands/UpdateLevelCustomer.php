<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\CustomerDiscount;
use Illuminate\Console\Command;

class UpdateLevelCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatelevel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update level customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customers = Customer::all();
        $dt = \Carbon\Carbon::now();
        $recent_quarter = $dt->quarter;
        $old_quarter = $recent_quarter - 1;
        $maxRoleLevel = CustomerDiscount::min('level');
        foreach ($customers as $customer){
            switch ($old_quarter) {
                case '1':
                    $order = $customer->BetweenMonth(1,3);
                    break;
                case '2':
                    $order = $customer->BetweenMonth(4,6);
                    break;
                case '3':
                    $order = $customer->BetweenMonth(7,9);
                    break;
                case '0':
                    $order = $customer->BetweenMonthOldYear(10,12);
                    break;
                default:
                    # code...
                    break;
            }
            
            if(!empty($order) && count($order)>0){
                $revenue = $order->sum('total_price')-($order->sum('total_shipping')+$order->sum('total_discount')+$order->sum('total_sale'));
                $test[$customer->id] = $revenue;
                $role = $customer->CustomerRole;
                if($role && $role->level != $maxRoleLevel){
                    $nextRole = CustomerDiscount::where('level', '<', $role->level)->orderBy('level', 'DESC')->first();
                    if($revenue >=  $nextRole->condition_apply){
                        $customer->update(['customer_role_id' => $nextRole->id]);
                    }
                }
            }
        }
    }
}
