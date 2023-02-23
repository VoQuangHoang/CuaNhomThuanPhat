<?php

namespace App\Repositories\Products;


use Exception;
use Carbon\Carbon;
use App\Models\Tags;
use App\Models\Orders;
use App\Models\Coupons;
use App\Models\Customer;
use App\Models\Payments;
use App\Models\Products;
use App\Models\LogPayment;
use App\Models\ProductTag;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Models\ProductBonus;
use App\Models\AttributeValues;
use App\Models\CustomerDiscount;
use App\Models\OrderProductBonus;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Validators\Products\ProductsValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Products\ProductsRepository;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * Class ProductsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Products;
 */
class ProductsRepositoryEloquent extends BaseRepository implements ProductsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Products::class;
    }

    public function getSearchProduct($request)
    {
        $query= \App\Models\Products::select("products.*");
        // dd($query);
        if($request->filled('category') && $request->query('category')){
            $category = $request->query('category');
            $query = $query->whereHas('Category', function ($q) use ($category) {
                $q->where('product_category.category_id', '=', $category);
            });
        }
        if($request->filled('keyword')){
            $keyword = trim($request->query('keyword'));
            $query = $query->where('name', 'like', '%'.$keyword.'%');
        }

        if($request->filled('status')){
            $status = (int)$request->query('status');
            $query = $query->where('status', '=', $status);
        }

        if($request->author && $request->filled('author')){
            $authorId = (int)$request->query('author');
            $query = $query->where('user_id', '=', $authorId);
        }

        if($request->filled('daterange')){
            $daterange = $request->query('daterange');
            $time = explode(" - ", $daterange);
            $startDate = Carbon::createFromFormat('d/m/Y', $time[0])->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $endDate   = Carbon::createFromFormat('d/m/Y', $time[1])->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
            
            $query = $query->where(function ($q) use ($startDate, $endDate) {
                $datetime = "DATE(products.created_at) >= ? and DATE(products.created_at) <= ?";
                return $q->whereRaw($datetime, [$startDate, $endDate]);
            });
        }

        $products = $query->orderBy('created_at', 'DESC')->get();
        return $products;
    }

    public function addProduct($request)
    {
        $data = $request->all();

        $data['slug'] =  SlugService::createSlug(Products::class, 'slug', $request->name);

        $data['status'] = $request->status;

        $data['sku'] = $request->sku;

        $data['popular'] = $request->popular == 1 ? 1 : 0;

        $data['user_id'] =  Auth::user()->id;
        
        if(!empty($data['list'])){
            $data['more_image'] = json_encode($data['list']);
        }
        
        $product = $this->model->create($data);

        if(!empty($request->category)){
            foreach ($request->category as $item) {

                \App\Models\ProductCategory::create(['category_id'=> $item, 'product_id'=> $product->id]);
            }
        }

        // if($request->tags){
        //     $tagsAll = Tags::where('type', 1)->pluck('name')->toArray();

        //     $tags = $data['tags'];

        //     $addTagsAll = array_diff($tags, $tagsAll);

        //     foreach ($addTagsAll as $item){
        //         Tags::create(['name' => $item, 'slug' => Str::slug($item), 'type' => 1, 'description' => $item]);
        //     }

        //     foreach ($tags as $item){
        //         $idTag = Tags::where('name', $item)->where('type', 1)->first();
        //         ProductTag::create(['product_id' => $product->id, 'tag_id' => $idTag->id]);
        //     }
        // }

    }

    public function updateProduct($request, $id)
    {
        $product = Products::findOrFail($id);

        $data = $request->all();

        $data['status'] = $request->status;

        $data['popular'] = $request->popular == 1 ? 1 : 0;

        $data['sku'] = $request->sku;

        if(!empty($data['list'])){
            $data['more_image'] = json_encode($data['list']);
        }else{
            $data['more_image'] = NULL;
        }

        if($product->slug != $data['slug']){
            $data['slug'] =  SlugService::createSlug(Products::class, 'slug', $request->name);
        }

        if(!empty($request->category)){
            \App\Models\ProductCategory::where('product_id', $id )->delete();
            foreach ($request->category as $item) {
                \App\Models\ProductCategory::create(['category_id'=> $item, 'product_id'=> $id ]);
            }
        }

        $product->update($data);

        // if($request->tags){
        //     $tagsAll = Tags::where('type', 1)->pluck('name')->toArray();

        //     $tags = $request->tags ? $request->tags : [];

        //     $addTagsAll = array_diff($tags, $tagsAll);

        //     foreach ($addTagsAll as $item){
        //         Tags::create(['name' => $item, 'slug' => Str::slug($item), 'type' => 2, 'description' => $item]);
        //     }

        //     $oldProductTags = $product->Tags->keyBy('id');
        //     $formattedTags = [];

        //     foreach ($oldProductTags as $key => $tag) {
        //         $formattedTags[$key] = $tag->name;
        //     }
            
        //     $newProductTags = !empty($tags) ? $tags : [];
            
        //     $delProductTags = array_diff($formattedTags, $newProductTags);

        //     if(!empty($delProductTags)){
        //         foreach ($delProductTags as $item){
        //             $tagId = array_search($item, $formattedTags);
        //             $idTag = ProductTag::where('tag_id', $tagId)->where('product_id', $product->id)->first()->id;
        //             ProductTag::destroy($idTag);
        //         }
        //     };
            
        //     $addProductTags = array_diff($newProductTags, $formattedTags);
        //     if(!empty($addProductTags)){
        //         foreach ($addProductTags as $item){
        //             $idTag = Tags::where('name', $item)->where('type', 1)->first();
        //             ProductTag::create(['product_id' => $product->id, 'tag_id' => $idTag->id]);
        //         }
        //     }
        // }
    }

    public function getProductBySlug($slug)
    {
        $data = $this->model->where(['slug' => $slug, 'status' => '1'])->first();
        return $data;
    }

    public function getPopularProducts($take)
    {
        $data = $this->model->where(['status' => 1, 'popular' => 1])
            ->orderBy('created_at', 'DESC')->take($take)->with('Category')->get();
        return $data;
    }

    public function getSaleProducts($take)
    {
        $data = $this->model->where(['status' => 1, 'sale' => 1])
            ->orderBy('created_at', 'DESC')->take($take)->with('Category')->get();
        return $data;
    }


    public function productByCategory($request, $data, $paginate)
    {
        $idCate = $data->id;
        $arrayProductsID = \App\Models\ProductCategory::where('category_id', $idCate)
            ->pluck('product_id')->toArray();

        $productsQuery = $this->model->select("products.*", "product_reviews.stars", DB::raw('(CASE WHEN products.price_sale > 0 THEN products.price_sale ELSE products.price END) AS priceMin'))
            ->leftJoin(DB::raw("(SELECT
                product_reviews.product_id,
                round(avg(product_reviews.star),1) as stars 
                FROM product_reviews
                WHERE status = 1
                GROUP BY product_reviews.product_id 
                ) as product_reviews "), function ($join) { 
                    $join->on("product_reviews.product_id","=","products.id");
                })->groupBy("products.id")->where('products.status', 1)->whereIn('products.id', $arrayProductsID);

        if($request->filled('brand')){
            $brand = (int)$request->query('brand');
            $productsQuery = $productsQuery->where(function ($q) use ($brand) {
                return $q->where('brand_id', '=', $brand);
            });
        }

        if($request->filled('stock')){
            $stock = trim($request->query('stock'));
            $productsQuery = $productsQuery->when($stock == 'in_stock', function ($q) {
                return $q->having('instock', '=', 1);
            });
        }

        if($request->filled('sale')){
            $sale = trim($request->query('sale'));
            $productsQuery = $productsQuery->when($sale == 'in_sale', function ($q) {
                return $q->having('sale', '=', 1);
            });
        }

        if($request->filled('price_from') && $request->query('price_to')){
            $price_from = (int)$request->query('price_from');
            $price_to = (int)$request->query('price_to');
            $productsQuery = $productsQuery->havingRaw("priceMin BETWEEN $price_from AND $price_to");
        }

        if($request->filled('star')){
            $star = (int)$request->query('star');
            $productsQuery = $productsQuery->having('stars', '>=', $star);
        }


        if($request->filled('capacity')){
            $capacity = (int)$request->query('capacity');
            $productsQuery = $productsQuery->having('capacity', '=', $capacity);
        }
        

        if($request->filled('sort')){
            $sort = trim($request->query('sort'));

            $productsQuery = $productsQuery->when($sort == 'popular', function ($q) {
                return $q->having('popular', '=', 1);
            });
            
            $productsQuery = $productsQuery->when($sort == 'desc', function ($q) {
                return $q->orderBy('created_at', 'DESC');
            });

            $productsQuery = $productsQuery->when($sort == 'asc', function ($q) {
                return $q->orderBy('created_at', 'ASC');
            });

            $productsQuery = $productsQuery->when($sort == 'price_desc', function ($q) {
                return $q->orderBy('priceMin', 'DESC');
            });
            $productsQuery = $productsQuery->when($sort == 'price_asc', function ($q) {
                return $q->orderBy('priceMin', 'ASC');
            });
        }else{
            $productsQuery = $productsQuery->orderBy('created_at', 'DESC');
        }
       
        $productByCate = $productsQuery->paginate($paginate)->appends($request->query());

        return $productByCate;
    }

    public function productSameCategory($dataProduct, $take)
    {
        $idCateArray = $dataProduct->Category->pluck('id')->toArray();
        $arrayProductsID = \App\Models\ProductCategory::whereIn('category_id', $idCateArray)
            ->pluck('product_id')->toArray();
        $productSameCategory = $this->model->where('status',1)->where('id','!=',$dataProduct->id)
            ->whereIn('id', $arrayProductsID)->orderBy('created_at', 'DESC')->take($take)->get();
        return $productSameCategory;
    }

    public function productByCategoryId($id, $take)
    {
        $arrayProductsID = \App\Models\ProductCategory::where('category_id', $id)
            ->pluck('product_id')->toArray();
        $data = $this->model->where('status',1)->whereIn('id', $arrayProductsID)
            ->orderBy('created_at', 'DESC')->take($take)->get();
        return $data;
    }

    public function saveOrder($request, $customer_id){
        $dataCart = getDataCart($request->city_id, $request->district_id);
        $customer = Auth::guard('customer')->user();
        $subtotal = Cart::instance('shopping')->priceTotal(0, 3, false);
      
        $order                  = new Orders;
        $order->customer_id         = $customer_id;
        $order->sku             = generateRandomCode(6);
        $order->sale_price      = $dataCart->get('discount');
        $order->code            = $dataCart->get('code');
        $order->total_price     = $dataCart->get('total');
        $order->discount_price  = $dataCart->get('cus_discount');
        $order->payment_type    = $request->payment_type;
        $order->email           = $request->email;
        $order->name            = $request->name;
        $order->phone           = $request->phone;
        $order->city_id         = $request->city_id;
        $order->district_id     = $request->district_id;
        $order->ward_id         = $request->ward_id;
        $order->address         = $request->address;
        $order->status          = '01';
        $order->note            = $request->note;
        $order->shipping_fee    = $dataCart->get('shipping');
        $order->total_weight    = Cart::instance('shopping')->weight(0, 3, false);

        $order->save();
        
        foreach (Cart::instance('shopping')->content() as $item) {
            $orderDetail                   = new OrderDetail;
            $orderDetail->order_id         = $order->id;
            $orderDetail->product_id       = $item->id;
            $orderDetail->qty              = $item->qty;
            $orderDetail->price            = $item->price;
            $orderDetail->product_attribute_id  = $item->options->product_attribute_id;
            $orderDetail->total_price            = $item->price * $item->qty;
            $orderDetail->save();

            if($request->receive_gifts == 1 && !session()->has('coupon')){
                $bonus_product = getProductBonus($item->id, $item->qty);
                if (!empty($bonus_product)) {
                    foreach ($bonus_product as $bonus) {
                        OrderProductBonus::create([
                            'order_detail_id' => $orderDetail->id,
                            'product_id' => $item->id,
                            'product_bonus_id' => $bonus->product_bonus_id,
                            'qty' => $bonus->bonus_quantity,
                        ]);
                    }
                }
            }
        }

        if(empty($customer->customer_role_id)){
            $check_discount = CustomerDiscount::where('condition_apply','<=',$subtotal)->orderBy('level', 'asc')->first();
            if($check_discount){
                Customer::find($customer->id)->update(['customer_role_id' => $check_discount->id]);
            }
        }

        // $dataMail['url'] =  route('order.edit',['id' => $order->id]);

        // $dataMail = [
        //     'sku'        => $order->sku,
        //     'name'        => $request->name,
        //     'email'        => $request->email,
        //     'phone'       => $request->phone,
        //     'address'     => $request->address,
        //     'cart'        => Cart::content(),
        //     'type'        => $request->type_checkout,
        //     'total'       => Cart::total(),
        //     'url'       => route('order.edit', $order->id),
        //     'payment_method'       => PaymentMethod::mappingName($order->type),
        // ];

        // // event(new OrderEvent($dataMail));
        // $email_admin = getOptions('general', 'email_admin');
        // Mail::send('frontend.mail.mail-order', $dataMail, function ($msg) use($email_admin) {
        //     $msg->from(config('mail.mail_from'), 'Hưng Đại Nam');
        //     $msg->to($email_admin, 'Hưng Đại Nam')->subject('Bạn có đơn hàng mới');
        // });

        Cart::instance('shopping')->destroy();
        session()->forget('coupon');
        session()->forget('referral');
        return $order;

    }

    public function vnPayPayments($order){
        $payment = Payments::where('type','vnpay')->first();
        if(!$payment){
            return false;
        }
        
        $total_price = $order->total_price;
        $vnp_TmnCode = $payment->vnp_TmnCode;
        $vnp_HashSecret = $payment->vnp_HashSecret; 
        $vnp_Url = $payment->url_pay;
        $vnp_Returnurl = route('home.checkout_callback');
        $vnp_TxnRef = $order->sku.$order->id;
        $vnp_OrderInfo = $payment->payment_name;
        $vnp_OrderType = '210000';
        $vnp_Amount = $total_price*100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        


        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
    
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;

    }

    public function checkCallbackVnpay($request){

        $payment = Payments::where('type','vnpay')->first();
        $vnp_HashSecret = $payment->vnp_HashSecret;

        $inputData = array();

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $vnpResponseCode = $inputData['vnp_ResponseCode'];
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                if ($vnpResponseCode == '00') {
                    return redirect()->route('home.checkout.success');
                } else {
                    //GD thất bại, đẩy ra trang lỗi
                    return redirect()->route('home.checkout.error');
                }
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function updateOrderVnpay($request){

        $payment = Payments::where('type','vnpay')->first();
        $vnp_HashSecret = $payment->vnp_HashSecret;

        $inputData = array();
        $returnData = array();
        $data = $request->all();

        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $vnpTmncode = $inputData['vnp_TmnCode'];
        $vnp_Amount = $inputData['vnp_Amount']/100;
        $payDate = $inputData['vnp_PayDate'];
        $vnpResponseCode = $inputData['vnp_ResponseCode'];
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];
        
        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                $order = NULL;
                $idorder = substr($orderId,9);
                $order = Orders::find($idorder);
                // $order_detail = $order->OrderDetail;
                // $point = 0;
                if ($order != NULL) {
                    if($order->total_price == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. 
                    //$order["Amount"] == $vnp_Amount
                    {
                        if ($order->status != NULL && $order->status == 6) {
                            if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                                $order->update(['status' => 4]);
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                                $order->update(['status' => $vnpResponseCode]);
                            }

                            $model = new LogPayment();
                            $model->ma_gd = $vnpTranId;
                            $model->ma_dh = $orderId;
                            $model->ma_website = $vnpTmncode;
                            $model->ngan_hang = $vnp_BankCode;
                            $model->so_tien = $vnp_Amount;
                            $model->order_id = $order->id;
                            $model->type_payment = 'vnpay';
                            $model->ngay_tao = $payDate;
                            $model->trang_thai = $vnpResponseCode;
                            $model->noidung_tt = $inputData['vnp_OrderInfo'];
                            $model->save();
                                            
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                                $returnData['RspCode'] = '02';
                                $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                    
                

                    // $dataMail = [
                    //     'name'        => $order->name,
                    //     'phone'       => $order->phone,
                    //     'address'     => $this->getAddress($order->city_id,$order->district_id,$order->ward_id),
                    //     'cart'        => $order_detail,
                    //     'payments'        => 3,
                    //     'type'        => 3,
                    //     'status'        => 4,
                    //     'total'       => $order->total_price,
                    //     'url'       => route('order.edit', $order->id),
                    // ];

                    // event(new OrderEvent($dataMail));
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        echo json_encode($returnData);
    }

    public function checkoutSuccess($request){
        if(Cart::instance('shopping')->count() == 0){
            return redirect()->back()->with('toastr_err','Giỏ hàng hiện đang trống.');
        }

        $customer_id = null;

        if(Auth::guard('customer')->check()){
            $customer_id = Auth::guard('customer')->user()->id;
        }
        
        // try {
            switch ($request->payment_type) {
                case '1':
                case '2':
                    $order = $this->saveOrder($request,$customer_id);
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'url' => route('home.checkout.success')
                    ]);
                    break;
                case '3':
                    $order = $this->saveOrder($request,$customer_id);
                    $order->status = 6;
                    $order->save();
                    $vnp_Url = $this->vnPayPayments($order);
                    // dd($vnp_Url);
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'url' => $vnp_Url
                    ]);
                    break;
                default:
                    break;
            }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     abort(404);
        // }
    }

    public function checkReferral($request){
        $action = $request->action;
        $code = $request->code;
        
        if($action == 'apply'){
            if ($code != ''){
                $customer = Customer::where('referral_code', $code)->first();
                if($customer && $customer->is_aff == 1){
                    session()->put('referral', $customer->referral_code);
                    return response()->json([
                        'success'=>true,
                        'message'=>'Áp dụng mã giới thiệu thành công',
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giới thiệu không hợp lệ hoặc tài khoản giới thiệu chưa đăng ký Affiliate',
                    ]);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập mã giới thiệu',
            ]);
        }else{
            session()->forget('referral');

            return response()->json([
                'success' => true,
                'remove' => true,
                'message' => 'Đã xóa mã giới thiệu',
            ]);
        }
    }

    public function checkDiscount($request){
        $total = Cart::instance('shopping')->priceTotal(0, 3, false);

        $action = $request->action;
        $code = $request->code;
        if(!$request->city_id || !$request->district_id){
            return response()->json([
                'success' => false,
                'message' => 'Chọn tỉnh thành phố, và quận huyện để tiếp tục',
            ]);
        }
        if($action == 'apply'){
            if(!empty($request->receive_gifts) && $request->receive_gifts == 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể áp dụng mã giảm giá khi đã nhận sản phẩm khuyến mãi.',
                ]);
            }
            if ($code != '') {
                $data = Coupons::where(['code' => $code, 'status' => 1])->first();
                if($data)
                {
                    // if(($data->close == 1 && !Auth::guard('customer')->check()) || ($data->close==1 && Auth::guard('customer')->user()->close !=1)) {
                    //     return response()->json([
                    //         'success'=>false,
                    //         'message'=>'Chưa đủ điều kiện sử dụng mã khuyến mãi',
                    //         'desc' => ''
                    //     ]);
                    // }

                    if(!empty($data->condition)){
                        if($total < $data->condition){
                            return response()->json([
                                'success'=>false,
                                'message'=>'Chưa đủ điều kiện sử dụng mã khuyến mãi',
                                'desc' => ''
                            ]);
                        }
                    }

                    session()->put('coupon', [
                        'code' => $data->code,
                        'discount' => $data->discount($total)
                    ]);
                    $dataCart = getDataCart($request->city_id, $request->district_id);
                    // dd($dataCart);
                    // $view_cart = view('frontend.elements.cart_order_detail', ['dataCart' => $dataCart])->render();

                    return response()->json([
                        'success'=>true,
                        'message'=>'Áp dụng mã khuyến mãi thành công',
                        'desc' => $data->desc,
                        'discount' => number_format($dataCart['discount'], 0, 3,'.').' đ',
                        'code' => $dataCart['code'],
                        'subtotal' => $dataCart['subtotal'],
                        'shipping' => number_format($dataCart['shipping'], 0, 3,'.').' đ',
                        'total' => number_format($dataCart['total'], 0, 3,'.').' đ',
                    ]);

                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Mã khuyến mãi không hợp lệ hoặc hết hạn sử dụng',
                        'desc' => ''
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập mã khuyến mãi',
            ]);
        } else {
            session()->forget('coupon');
            $dataCart = getDataCart($request->city_id, $request->district_id);
            // $view_cart = view('frontend.elements.cart_order_detail', ['dataCart' => $dataCart])->render();

            return response()->json([
                'success' => true,
                'remove' => true,
                'message' => 'Đã xóa mã khuyến mãi',
                'discount' => number_format($dataCart['discount'], 0, 3,'.').' đ',
                'code' => $dataCart['code'],
                'subtotal' => $dataCart['subtotal'],
                'shipping' => number_format($dataCart['shipping'], 0, 3,'.').' đ',
                'total' => number_format($dataCart['total'], 0, 3,'.').' đ',
            ]);
        }

        
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
