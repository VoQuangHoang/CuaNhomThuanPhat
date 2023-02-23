<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use File;
use Session;
use Validator;
use App\Models\City;
use App\Models\Ward;
use App\Models\Customer;
use App\Models\Products;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\ProductWishlist;
use App\Models\CustomerDiscount;
use App\Events\ForgotPasswordEvent;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Services\ViettelPostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Pages\PagesRepository;
use App\Http\Requests\Frontend\PostLoginRequest;
use App\Repositories\Customer\CustomerRepository;
use App\Http\Requests\Frontend\PostRegisterRequest;
use App\Http\Requests\Frontend\CreateCustomerRequest;
use App\Http\Requests\Frontend\UpdateCustomerRequest;
use App\Http\Requests\Frontend\PostUserAddressRequest;
use App\Http\Requests\Frontend\UpdatePasswordCustomer;
use App\Http\Requests\Frontend\PostChangePasswordRequest;
use App\Http\Requests\Frontend\PostForgotPasswordRequest;

class CustomerController extends Controller
{
    protected $pages, $customer, $viettelPost;

    public function __construct(PagesRepository $pages, CustomerRepository $customer, ViettelPostService $viettelPost)
    {
        $this->pages = $pages;
        $this->customer = $customer;
        $this->viettelPost = $viettelPost;
        $this->pages->seoGeneral();
    }

    public function getLogin()
    {
        if(Auth::guard('customer')->check()){
            return redirect()->route('home.index');
        }else{
            $dataSeo = $this->pages->getDataByType('login');
            $this->pages->createSeo($dataSeo);
            $contentPage = json_decode($dataSeo->content);
            return view('frontend.pages.login', compact('contentPage', 'dataSeo'));
        }
        
    }

    public function postLogin(PostLoginRequest $request, Validator $validator)
    {
        $data = $request->all();

        $arrEmail = [ 'email' => $data['username'], 'password' => $data['password'], ];
        $arrPhone = [ 'phone' => $data['username'], 'password' => $data['password'], ];
        if ($this->customer->postLoginCustomer($arrEmail) || $this->customer->postLoginCustomer($arrPhone)) {
            if(Auth::guard('customer')->user()->confirmed == 1){
                $customer = Auth::guard('customer')->user();
                $pro_wishlist = ProductWishlist::where(['customer_id' => $customer->id])->get();
                if(!empty($pro_wishlist)){
                    foreach($pro_wishlist as $item) {
                        $product = Products::find($item->product_id);
                        $dataCart    = [
                            'id'      => $product->id,
                            'name'    => $product->name,
                            'qty'     => 1,
                            'price'   => $product->price,
                            'weight'  => 0,
                        ];
                        Cart::instance('wishlist')->add($dataCart);
                    }
                }
                if(Auth::guard('customer')->user()->is_aff == 1)
                {
                    return response()->json([
                        'success'=> 1,
                        'message'=>"Đăng nhập thành công, đang chuyển hướng",
                        'redirect' => route('home.affiliate'),
                    ]);
                }
                return response()->json([
                    'success'=> 2,
                    'message'=>"Đăng nhập thành công, đang chuyển hướng",
                    'redirect' => route('home.index'),
                ]);
            }else{
                $code = Auth::guard('customer')->user()->code;
                Auth::guard('customer')->logout();
                return response()->json([
                    'success'=> 3,
                    'message'=> "Tài khoản chưa xác thực, đang chuyển hướng về trang xác thực tài khoản",
                ]);
            } 
        }else{
            return response()->json([
                'success'=> 4,
                'message'=> "Tài khoản hoặc mật khẩu không đúng"
            ]);
        }
    }

    public function getRegister()
    {
        $dataSeo = $this->pages->getDataByType('register');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.register', compact('contentPage', 'dataSeo'));
    }

    public function postRegister(PostRegisterRequest $request)
    {
        $customer = $this->customer->storeUser($request);
        if(!empty($customer)){
            return response()->json([
                'success'=> 1,
                'message'=>"Đăng kí thành công. Vui lòng đăng nhập",
                'redirect' => route('home.login')
            ]);
        }else{
            return response()->json([
                'success'=> 2,
                'message'=>"Đăng kí không thành công. Vui lòng thử lại"
            ]);
        }
    }

    public function getLogout(){
        try {
            Auth::guard('customer')->logout();
            Session::flush();
            return \Redirect::route('home.login');
        } catch (Exception $e) {
            abort(404);
        }
    }
    

    public function getInformationCustomer()
    {
        try {
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);

            $customer = Auth::guard('customer')->user();

            $customerAddress = CustomerAddress::where('customer_id', $customer->id)->orderBy('is_default', 'DESC')->paginate(3);
            $ward = Ward::all();

            $dataOrder = $this->customer->getOrderInInForCustomer($customer->id);
            $orders = $customer->CustomerOrders()->orderBy('created_at', 'DESC')->take(2)->get();
            $orderDetail = OrderDetail::all();
            $products = Products::all();
            $viettel_post = new ViettelPostService();

            return view('frontend.customer.information')->with(compact(['customer', 'customerAddress', 'ward', 'dataOrder', 'orderDetail', 'products','viettel_post','orders']));
        } catch (Exception $e) {
            abort(404);
        }
    }

    //===== Update info Customer
    public function customerEditInfo()
    {
        try {
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);

            $customer = $this->customer->find(Auth::guard('customer')->id());

            if($customer->image != null){
                $ava = $customer->image;
            }else{
                $ava = null;
            }

            return view('frontend.customer.edit_info')->with(compact([
                'customer',
                'ava',
            ]));
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function postCustomerEditInfo(UpdateCustomerRequest $request){
       try {
            $data = $request;
            $id_customer = Auth::guard('customer')->id();
            if($image = $request->file('avatar')){
                // Xóa file cũ
                $destinationPath = public_path('frontend/avatar/');
                File::delete($destinationPath . Customer::find($id_customer)->image);
                // Upload file mới
                $image = $request->file('avatar');
                $input['imagename'] = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $destinationPath = public_path('frontend/avatar');
                $image->move($destinationPath, $input['imagename']);
            }else{
                $input['imagename'] = Customer::find($id_customer)->image;
            }
            
            $customer = Customer::find($id_customer);

            $customer->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'image' =>  $input['imagename'],
            ]);

            $dataRes = new Customer();
            $dataRes->name = $customer->name;
            $dataRes->phone = $customer->phone;
            $dataRes->gender = $customer->gender;
            $dataRes->email = $customer->email;
            $dataRes->image = $customer->image;

            return Response()->json([
                    "success" => true,
                    "message" => "Thay đổi thành công",
            ]);
       } catch (Exception $e) {
            abort(404);
       }
    }
    //===== End Update info Customer


    //===== Andress Customer
    public function customerAddressPage()
    {
        try {
            $viettel_post = new ViettelPostService();
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);

            $vtpost_city = $this->viettelPost->provinces();
            
            $address = CustomerAddress::where('customer_id', Auth::guard('customer')->user()->id)->orderBy('is_default', 'DESC')->paginate(3);

            return view('frontend.customer.address')->with(compact('address','vtpost_city','viettel_post'));
        } catch (Exception $e) {
            abort(404);
        }
       
    }

    public function setAddressDefault($id){
        if($this->customer->setAddressDefaultCustomer($id)){
            return back()->with('success', 'Cập nhật địa chỉ mặc định thành công');
        }
        return back()->with('error', 'Lỗi cập nhật');
    }

    public function deleteAddressCustomer($id){
        try {
            CustomerAddress::find($id)->delete();
            return back()->with('success', 'Xóa địa chỉ thành công');
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function postCustomerAddress(PostUserAddressRequest $request){
        try {
            $customer_id = Auth::guard('customer')->id();
            if($this->customer->createAddressCustomer($request, $customer_id)){
                return response()->json([
                    "success" => true,
                    "message" => "Đã thêm địa chỉ mới",
                ]);
            }
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function getUpdateAddressCustomer($id){

        try {
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);
            $cus_id = Auth::guard('customer')->id();
            $address = CustomerAddress::findOrFail($id);
            $vtpost_city = $this->viettelPost->provinces();
            $vtpost_district = $this->viettelPost->districts($address->city_id);
            $vtpost_ward = $this->viettelPost->wards($address->district_id);
            if($cus_id != $address->customer_id){
                return redirect()->route('home.customer.address');
            }
            return view('frontend.customer.change_address',compact('address','vtpost_city', 'vtpost_district', 'vtpost_ward'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function postUpdateAddressCustomer($id, PostUserAddressRequest $request){
        //updateAddressCustomer
        try {
            if($this->customer->updateAddressCustomer($id, $request)){
                return response()->json([
                    "success" => true,
                    "message" => "Cập nhật địa chỉ thành công",
                ]);
            }
        } catch (Exception $e) {
            abort(404);
        }
    }

    
    //===== End Andress Customer


    //===== Change Pass Customer
    public function customerChangePassword()
    {
        try {
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);

            return view('frontend.customer.change_pass');
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function postCustomerChangePassword(UpdatePasswordCustomer $request){
        try {
            $customer = Auth::guard('customer')->user();
            if(Hash::check($request->password, $customer->password)){
                $customer->update(['password' => Hash::make($request->password_new)]);
                    return Response()->json([
                        "success" => true,
                        "message" => "Thay đổi thành công",
                    ]);
            }else{
                return Response()->json([
                        "success" => 2,
                        "message" => "Mật khẩu hiện tại không đúng.",
                ]);
            }
        } catch (Exception $e) {
            abort(404);
        }
    }

    //===== END Change Pass Customer


    public function customerAddressAdd()
    {
        return view('frontend.customer.address_add');
    }


    public function customerOrderPage()
    {   
        try {
            $dataSeo = $this->pages->getDataByType('customer_info');
            $this->pages->createSeo($dataSeo);
            $customer_id = Auth::guard('customer')->id();
            $orders = $this->customer->getOrderCustomer($customer_id);
            return view('frontend.customer.order')->with(compact(['orders'])); 
        } catch (Exception $e) {
            abort(404);
        }
       
    }

    public function updateInfomationSocial(PostUpdateSocial $request)
    {
        $user = \App\Models\Customer::where('code', $request->code)->first();
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'confirmed' => 1,
            'code' => ''
        ];
        $user->update($data);
        Auth::guard('customer')->login($user);
        return response()->json([
            'success' => true,
            'url' => route('home.index')
        ]);
    }

    // Get forgot password
    public function getForgotPassword()
    {
        if(Auth::guard('customer')->check()){
            return redirect()->route('home.index');
        }else{
            $dataSeo = $this->pages->getDataByType('forgot_password');

            $this->pages->createSeo($dataSeo);

            $contentPage = json_decode($dataSeo->content);

            return view('frontend.pages.forgot_password', compact('dataSeo','contentPage'));
        }
    }

    public function sendMailForgotPassword(PostForgotPasswordRequest $request){
        
        $code = $this->customer->getToken();

        $customer =  $this->customer->where('email', $request->email)->first();

        if(!empty($customer)){
            $customer->update(['code' => $code]);
            $content_mail = [
                'url' => Url::temporarySignedRoute('home.update_password', now()->addMinutes(10), ['code'=>$code])
            ];

            event(new ForgotPasswordEvent($customer,$content_mail));

            return response()->json([
                'success'=> 1,
                'message'=> "Vui lòng kiểm tra email của bạn để đặt lại mật khẩu"
            ]);

        }else{
            return response()->json([
                'success'=> 2,
                'message'=>"Email không tồn tại. Vui lòng kiểm tra lại"
            ]);
        }
    }
    
    // Get change password
    public function getUpdatePassword(Request $request, $code)
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('home.forgot_password')->with('error', 'Liên kết đặt lại mật khẩu của bạn đã hết hạn. Vui lòng thử lại!');
        }
        
        $dataSeo = $this->pages->getDataByType('update_password');

        $this->pages->createSeo($dataSeo);

        $contentPage = json_decode($dataSeo->content);

        return view('frontend.customer.update_password', compact('code', 'dataSeo', 'contentPage'));
    }

    public function postUpdatePassword(PostChangePasswordRequest $request, $code){
        try {
            $this->customer->where('code', $code)->update([
                'code' => NULL,
                'password' => Hash::make($request->password),
            ]);

        return response()->json([
            'success' => 1,
            'message' => "Đã cập nhật mật khẩu thành công. Chuyển hướng đến trang đăng nhập.",
            'url' => route('home.login'),
        ]);

            
        } catch (Exception $e) {
            return response()->json([
                'success' => 2,
                'message' => "Đã xảy ra sự cố. Vui lòng thử lại.",
                'url' => route('home.login'),
            ]);
        }
    }

    // Create customer
    public function createdCustomer()
    {
        $customer = Auth::guard('customer')->user();
        $dataSeo = $this->pages->getDataByType('customer_info');
        $this->pages->createSeo($dataSeo);
        
        if($customer->CustomerRole){
            $role = CustomerDiscount::where('level', '>', $customer->CustomerRole->level)->orderBy('level', 'ASC')->get();
            if(count($role) > 0){
                return view('frontend.customer.create', compact('role'));
            };
        }
        return redirect()->route('home.customer.info')->with('warning', 'Tài khoản chưa có vai trò phù hợp');
    }

    public function postCreatedCustomer(CreateCustomerRequest $request)
    {
        $input = $request->all();

        $image = $request->file('image');
        if ($image){
        $input['image'] = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $destinationPath = public_path('frontend/avatar');
        $image->move($destinationPath, $input['image']);
        }
        $input['confirmed'] = 1;
        $input['is_aff'] = $request->is_aff == 1 ? 1 : 0;
        $input['created_id'] = Auth::guard('customer')->user()->id;
        $input['password'] = Hash::make($request->password);
        $this->customer->create($input);
        return response()->json([
            'success' => true,
            'message' => 'Thêm mới thành viên thành công',
            'redirect' => route('home.customer.list'),
        ]);
    }

    public function listCustomer()
    {
        $dataSeo = $this->pages->getDataByType('customer_info');
        $this->pages->createSeo($dataSeo);
        $customer = Auth::guard('customer')->user();
        $data = $this->customer->where('created_id', $customer->id)->orderBy('created_at', 'DESC')->paginate(9);
        if($customer->CustomerRole){
            $role = CustomerDiscount::where('level', '>', $customer->CustomerRole->level)->orderBy('level', 'ASC')->get();
            if(count($role) > 0){
                return view('frontend.customer.list', compact('data', 'role'));
            }
        }
        return redirect()->route('home.customer.info')->with('warning', 'Tài khoản chưa có vai trò phù hợp');
        
    }

    public function detailCustomer($id){
        $dataSeo = $this->pages->getDataByType('customer_info');
        $this->pages->createSeo($dataSeo);
        $auth = Auth::guard('customer')->user();
        $customer = $this->customer->where('id', $id)->where('created_id', $auth->id)->first();
        $orders = $customer->CustomerOrders()->orderBy('created_at', 'DESC')->paginate(5);
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $orderByMonth = $customer->AllMonth();
        $orderMonth1 = $customer->BetweenMonth(1,3);
        $orderMonth2 = $customer->BetweenMonth(4,6);
        $orderMonth3 = $customer->BetweenMonth(7,9);
        $orderMonth4 = $customer->BetweenMonth(10,12);
        $orderYear = $customer->ByYear();
        // dd($orderYear);
        return view('frontend.customer.detail', compact('customer','orders','months','orderByMonth','orderMonth1','orderMonth2','orderMonth3','orderMonth4','orderYear'));
    }

    public function updateRoleCustomer(Request $request, $id){
        try {
            $this->customer->find($id)->update(['customer_role_id' => $request->customer_role_id]);
            return back()->with('success', 'Cập nhật vai trò thành viên thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Lỗi cập nhật, vui lòng thử lại');
        }
        
    }
}
