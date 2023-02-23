<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ViettelPostService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Banks\BanksRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Orders\OrdersRepository;
use App\Repositories\Products\ProductsRepository;
use App\Http\Requests\Frontend\PostCheckoutRequest;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\OrderDetail\OrderDetailRepository;

class CheckoutController extends Controller
{
    protected $pages, $categories, $posts, $products, $banks, $orders, $order_detail, $viettelPost;

    public function __construct(PagesRepository $pages, CategoriesRepository $categories,
        ProductsRepository $products, BanksRepository $banks, OrdersRepository $orders,
        OrderDetailRepository $order_detail, ViettelPostService $viettelPost)
    {
        $this->pages = $pages;
        $this->categories = $categories;
        $this->products = $products;
        $this->banks = $banks;
        $this->orders = $orders;
        $this->order_detail = $order_detail;
        $this->viettelPost = $viettelPost;
        $this->pages->seoGeneral();
    }

    public function getCheckoutPage()
    {
        if(!Auth::guard('customer')->check())
        {
            return back()->with(['error' => "Đăng nhập để thanh toán giỏ hàng"]);
        }
        if(Cart::instance('shopping')->content()->count() == 0)
        {
            return redirect()->route('home.cart')->with(['error' => 'Giỏ hàng chưa có sản phẩm nào']);
        }

        $customer = Auth::guard('customer')->user();
        $dataCart = Cart::instance('shopping')->content();
        if($customer->customer_role_id && $customer->CustomerRole->quantity_apply){
            foreach ($dataCart as $item) {
                if($item->qty < $customer->CustomerRole->quantity_apply){
                    return redirect()->route('home.cart')->with(['warning' => $customer->CustomerRole->name.' mua mỗi sản phẩm với số lượng tối thiểu là '.$customer->CustomerRole->quantity_apply]);
                }
            }
        }
        $customer_discount = $customer->customer_role_id ? round(Cart::instance('shopping')->priceTotal(0, 3, false) * ($customer->CustomerRole->discount / 100)) : 0;
        $dataSeo = $this->pages->getDataByType('checkout');
        $this->pages->createSeo($dataSeo);
        
        $city = City::all();
        $banks = $this->banks->findByField('status', 1);
        $vtpost_city = $this->viettelPost->provinces();
        $selected_city = old('city_id');
        $selected_district = old('district_id');
        $vtpost_districts = [];
        if ($selected_city) {
            $vtpost_districts = $this->viettelPost->districts($selected_city);
        }
        return view('frontend.pages.checkout', compact('dataCart', 'city', 'banks','vtpost_city', 'selected_city', 'selected_district', 'vtpost_districts','customer_discount'));
    }

    public function successCheckout()
    {
        return view('frontend.pages.checkout_success');
    }

    public function errorCheckout()
    {
        return view('frontend.pages.checkout_error');
    }

    public function getDistrict(Request $request){

        $district = $this->viettelPost->districts($request->city_id);

        $html =  view('frontend.checkout.get-district',compact('district'))->render();

        return response()->json([
            'html' => $html,
        ]);
    }

    public function getWard(Request $request){

        $wards = $this->viettelPost->wards($request->district_id);

        $html = view('frontend.checkout.get-wards',compact('wards'))->render();

        $dataCart = getDataCart($request->city_id, $request->district_id);

        return response()->json([
            'html' => $html,
            'discount' => number_format($dataCart['discount'], 0, 3,'.').' ₫',
            'code' => $dataCart['code'],
            'subtotal' => $dataCart['subtotal'],
            'shipping' => number_format($dataCart['shipping'], 0, 3,'.').' ₫',
            'total' => number_format($dataCart['total'], 0, 3,'.').' ₫',
            'cus_discount' => number_format($dataCart['cus_discount'], 0, 3,'.').' ₫',
        ]);
    }
    
    public function getShipping(Request $request)
    {
        $dataCart = getDataCart($request->city_id, $request->district_id);
        $view_cart = view('frontend.elements.cart_order_detail', compact('dataCart'))->render();
        
        return response()->json([
            'view_cart' => $view_cart,
        ]);
    }

    public function checkDiscount(Request $request)
    {
        return $this->products->checkDiscount($request);
    }

    public function postCheckout(PostCheckoutRequest $request)
    {
        return $this->products->checkoutSuccess($request);
    }

    public function getCheckoutCallback(Request $request)
    {
        return $this->products->checkCallbackVnpay($request);
    }

    public function updateOrderVnpay(Request $request)
    {
        $this->products->updateOrderVnpay($request);
    }

    public function checkReferral(Request $request)
    {
        return $this->products->checkReferral($request);
    }
}
