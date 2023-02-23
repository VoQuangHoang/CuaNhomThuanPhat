<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\Ward;
use App\Models\Orders;
use App\Models\Products;
use App\Models\OrderDetail;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Validators\User\UserValidator;
use App\Repositories\User\UserRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\User;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    protected function getToken()
    {
        return hash_hmac('sha256', Str::random(20), config('app.key'));
    }

    // Register Customer
    public function storeUser($request){
        $token = $this->getToken();
        $data = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'name' => $request->name,
            'code' => $token,
            'active' => 1,
        ]);
        $data->assignRole('Khách hàng');
        return $data;
    }

    //===== Login Customer ========/
    public function postLoginCustomer($arr){

        if (Auth()->attempt($arr)) { 
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

            $customerAddress = CustomerAddress::where('user_id', $customer->id)->orderBy('is_default', 'DESC')->paginate(3);
            $ward = Ward::all();

            $dataOrder = $this->customer->getOrderInInForCustomer($customer->id);
            $orderDetail = OrderDetail::all();
            $products = Products::all();

            return view('frontend.customer.infomation')->with(compact(['customer', 'customerAddress', 'ward', 'dataOrder', 'orderDetail', 'products']));
        } catch (Exception $e) {
            abort(404);
        }
    }

    //=====  Address Customer ========/
    public function createAddressCustomer($request, $id){
        $data = $request->all();
        $check = isset($request->is_default) == true ? 1 : 0;
        if($check == 1){
            UserAddress::where('user_id', $id)->update([
                'is_default' => 0,
            ]);
        }

        return UserAddress::create([
            'user_id' => $id,
            'address' => $data['address'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'type' => $data['type'],
            'city_id' => $data['city_id'],
            'district_id' => $data['district_id'],
            'ward_id' => !empty($data['district_id']) ? $data['district_id'] : 0,
            'is_default'=> $check,
        ]);
    }

    //===== Get Order Customer ========/
    public function getOrderCustomer($customer_id){
        $orderCustomer = Orders::where('user_id', $customer_id)->orderBy('created_at', 'DESC')->paginate(5);
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
