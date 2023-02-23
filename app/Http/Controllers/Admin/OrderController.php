<?php

namespace App\Http\Controllers\Admin;

use View;
use App\Models\Orders;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ViettelPostService;
use App\Repositories\User\UserRepository;
use App\Repositories\Brands\BrandsRepository;
use App\Repositories\Orders\OrdersRepository;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;

class OrderController extends Controller
{
    protected $products, $categories, $brands, $product_category, $order, $order_detail, $customer;

    public function __construct(ProductsRepository $products, CategoriesRepository $categories,
        BrandsRepository $brands, ProductCategoryRepository $product_category, OrdersRepository $order,
        OrderDetailRepository $order_detail, UserRepository $user)
    {
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->order = $order;
        $this->product_category = $product_category;
        $this->order_detail = $order_detail;
        $this->user = $user;
    }
    public function getOrder()
    {
        if(auth()->user()->can('order list')){
            $order = $this->order->latest()->get();
            return view('admin.order.list', compact('order'));
        }
        abort(406);
    }

    public function getOrderDetail($id)
    {
        if(auth()->user()->can('order edit')){
            $order_detail = $this->order_detail->where('order_id', $id)->get();
            $order = $this->order->find($id);
            $viettel_post = new ViettelPostService();

            $nameProduct = '';
            foreach($order->OrderDetail as $key => $item) {
                $nameProduct .= ($key > 0 ? ', ' : '').$item->Product->name;
            };

            $dataViettel = Settings::where('type', 'viettel-post')->first();

            $content = json_decode($dataViettel->content);

            $login = ['login_id' => $content->login_id, 'password' => $content->password ];

            $userViettel = $viettel_post->login($login);

            $viettelStore = $viettel_post->getStore($userViettel);

            $storeAll = $viettelStore['data'];

            // dd($storeAll);
            return view('admin.order.order_detail', compact('order', 'order_detail', 'viettel_post', 'storeAll','nameProduct'));
        }
        abort(406);
    }

    public function getDeleteOrder($id)
    {
        if(auth()->user()->can('order delete')){
            $this->order->delete($id);
            return back()->with('success', 'Xóa đơn hàng thành công');
        }
        abort(406);
    }

    public function updateStatus(Request $request, $id)
    {
        if(auth()->user()->can('order edit')){
            $status = $request->pro_status;
            $order = $this->order->find($id);

            if($order->status == 4){
                return back()->with('warning', 'Đơn hàng đã xác nhận');
            }

            if($status == 4){
                // $log_iq = \App\Models\LogPointIQ::where('order_id', $id)->first();
                // $customer = $this->user->find($log_iq->customer_id);
                // $log_iq->update(['status' => 1, 'iq_total' => $customer->total_pointIQ+$log_iq->iq_number]);
                // $customer->update(['total_pointIQ' => $customer->total_pointIQ+$log_iq->iq_number]);
                $order->update(['status' => 4]);
                return back()->with('success', 'Xác nhận đơn hàng thành công');
            }
            $order->update(['status' => $status]);
            return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        }
        abort(406);
        
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('order delete')){
            if(!empty($request->chkItem)){
                foreach ($request->chkItem as $id) {
                    $this->order->delete($id);
                }
                return back()->with('success', 'Xóa đơn hàng thành công');
            }
            return back()->with('success', 'Xóa đơn hàng thành công');
        }
        abort(406);
    }

    public function vtpSelectStore(Request $request)
    {
        $input = $request->all();

        if(empty($input['store_id'])){
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng chọn kho lấy hàng',
            ]);
        }

        $order = Orders::find($input['order_id']);

        $order_price = $order->total_price - $order->shipping_fee;

        $viettel_post = new ViettelPostService();

        $dataViettel = Settings::where('type', 'viettel-post')->first();

        $content = json_decode($dataViettel->content);

        $login = ['login_id' => $content->login_id, 'password' => $content->password ];

        $userViettel = $viettel_post->login($login);

        $viettelStore = $viettel_post->getStore($userViettel);

        if($input['height'] > 0 && $input['width'] > 0 && $input['length'] > 0){
            $input['total_weight'] = round($input['height']*$input['width']*$input['length']/6000, 3)*1000;
            $weight_calc = $input['total_weight'];
        }

        foreach ($viettelStore['data'] as $store){
            if($store['groupaddressId'] == $input['store_id']){
                $selecStore = $store;
            }
        }
        
        $check_collection = $request->check_money_collection == 1 ? 1 : 0;

        $money_collection = $check_collection == 1 ? $input['money_collection'] : 0;

        $priceAll = $viettel_post->getPriceAll($selecStore, $order, $input['total_weight'], $order_price, $money_collection);

        if(!empty($input['vtp_service'])){
            $service = $request->vtp_service;
        }else{
            $service = $priceAll[0]['MA_DV_CHINH'];
        }

        $price = $viettel_post->getPrices($selecStore, $order, $input['total_weight'], $order_price, $money_collection, $service);

        $view_service = View::make('admin.order.view_service', compact('priceAll','service'))->render();

       
        if($price['status'] == 200){
            return response()->json([
                'status' => true,
                'shipping_price' => $price['data']['MONEY_TOTAL'],
                'total_price' => $input['money_collection'],
                'weight_calc' => !empty($weight_calc) ? $weight_calc : 0,
                'msg' => 'Đã cập nhật giá vận chuyển',
                'view_service' => $view_service
            ]);
        }

        if($price['status'] == 204){
            return response()->json([
                'status' => false,
                'msg' => 'Giá không áp dụng cho hành trình này! Chọn lại dịch vụ phù hợp',
            ]);
        }

        if($price['status'] == 205){
            return response()->json([
                'status' => false,
                'msg' => 'Lỗi hệ thống!',
            ]);
        }
    }

    public function vtpCreateBill(Request $request)
    {
        $input = $request->all();

        $order = Orders::find($input['order_id']);

        $order_price = $order->total_price - $order->shipping_fee;

        $viettel_post = new ViettelPostService();

        $dataViettel = Settings::where('type', 'viettel-post')->first();

        $content = json_decode($dataViettel->content);

        $login = ['login_id' => $content->login_id, 'password' => $content->password ];

        $userViettel = $viettel_post->login($login);

        $viettelStore = $viettel_post->getStore($userViettel);

        $check_collection = $request->check_money_collection == 1 ? 1 : 0;

        foreach ($viettelStore['data'] as $store){
            if($store['groupaddressId'] == $input['store_id']){
                $selecStore = $store;
            }
        }

        $bill = $viettel_post->createBill($selecStore, $order, $input, $order_price, $userViettel, $check_collection);

        if($bill['status'] == '200'){
            $order->update(['vtp_order_number' => $bill['data']['ORDER_NUMBER']]);
            return response()->json([
                'status' => true,
                'msg' => 'Đã đẩy đơn lên hệ thống ViettelPost thành công. Truy cập ViettelPost để kiểm tra đơn',
            ]);
        }
        return response()->json([
            'status' => false,
            'msg' => 'Đã có lỗi xảy ra! Vui lòng kiểm tra thông tin và thử lại',
        ]);
    }
    
}
