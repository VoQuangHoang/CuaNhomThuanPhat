<?php

namespace App\Repositories\Customer;

use App\Models\Ward;
use App\Models\Orders;
use App\Models\Customer;
use App\Models\Products;
use App\Models\OrderDetail;
use App\Models\CustomerAddress;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Validators\Customer\CustomerValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Customer\CustomerRepository;

/**
 * Class CustomerRepositoryEloquent.
 *
 * @package namespace App\Repositories\Customer;
 */
class CustomerRepositoryEloquent extends BaseRepository implements CustomerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Customer::class;
    }

    public function generateRandomCodeGt($num) 
    {
        $code = 'GT'.substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1,$num);
        $customer = Customer::where('referral_code', $code)->first();
        if($customer){
            $this->generateRandomCodeGt(8);
        }
        return $code;
    }

    public function getToken()
    {
        return hash_hmac('sha256', Str::random(20), config('app.key'));
    }

    // Register Customer
    public function storeUser($request){
        $token = $this->getToken();
        if($request->referral_code){
        $cus = Customer::where('referral_code', $request->referral_code)->first();
        }
    
        $data = Customer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'name' => $request->name,
            'code' => $token,
            'confirmed' => 1,
            'is_aff' => $request->is_aff == 1 ? 1 : 0,
            'aff_id' => $request->is_aff == 1 ? time().uniqid(true) : NULL,
            'created_id' => !empty($cus) ? $cus->id : 0,
            'referral_code' => $this->generateRandomCodeGt(8)
        ]);
        return $data;
    }

    //===== Login Customer ========/
    public function postLoginCustomer($arr){

        if (Auth::guard('customer')->attempt($arr)) { 
            return true;
        } else { 
            return false;
        }
    }

    public function getInformationCustomer()
    {
        try {
            $dataInformationCustomerPage = $this->pages->getDataByTypePage('informationcustomer');
            $this->pages->createSeo($dataInformationCustomerPage);

            $idCus = Auth::guard('customer')->user()->id;
            $customer = $this->customer->find($idCus);

            $customerAddress = CustomerAddress::where('customer_id', $customer->id)->orderBy('is_default', 'DESC')->paginate(3);
            $ward = Ward::all();

            $dataOrder = $this->customer->getOrderInInForCustomer($customer->id);
            $orderDetail = OrderDetail::all();
            $products = Products::all();

            return view('frontend.customer.infomation')->with(compact(['customer', 'customerAddress', 'ward', 'dataOrder', 'orderDetail', 'products']));
        } catch (Exception $e) {
            abort(404);
        }
    }

    // Address Customer
    public function createAddressCustomer($request, $id){
        $data = $request->all();
        $check = isset($request->is_default) == true ? 1 : 0;
        if($check == 1){
            CustomerAddress::where('customer_id', $id)->update([
                'is_default' => 0,
            ]);
        }

        return CustomerAddress::create([
            'customer_id' => $id,
            'address' => $data['address'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'type' => $data['type'],
            'city_id' => $data['city_id'],
            'district_id' => $data['district_id'],
            'ward_id' => !empty($data['ward_id']) ? $data['ward_id'] : NULL,
            'is_default'=> $check,
        ]);
    }

    public function setAddressDefaultCustomer($id){
        try {
            $cus_id = Auth::guard('customer')->id();
            CustomerAddress::where('customer_id', $cus_id)->update([
                    'is_default' => 0,
                ]);

            CustomerAddress::where('customer_id', $cus_id)->where('id', $id)->update([
                'is_default' => 1,
            ]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }

    public function updateAddressCustomer($id, $request){
        $input = $request->all();

        $cus_id = Auth::guard('customer')->id();

        $check = isset($request->is_default) == true ? 1 : 0;

        if($check == 1){
            CustomerAddress::where('customer_id', $cus_id)->update([
                'is_default' => 0,
            ]);
        }

        return CustomerAddress::find($id)->update([
            'address' => $input['address'],
            'phone' => $input['phone'],
            'name' => $input['name'],
            'type' => $input['type'],
            'city_id' => $input['city_id'],
            'district_id' => $input['district_id'],
            'ward_id' =>  $input['ward_id'],
            'is_default'=> $check,
        ]);
    
    }

    //Order Customer
    public function getOrderCustomer($customer_id){
        $orderCustomer = Orders::where('customer_id', $customer_id)->orderBy('created_at', 'DESC')->paginate(8);
        return $orderCustomer;
    }

    public function getOrderInInForCustomer($customer_id){
        $orderCustomer = Orders::where('customer_id', $customer_id)->orderBy('created_at', 'DESC')->limit(2)->get();
        return $orderCustomer;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
