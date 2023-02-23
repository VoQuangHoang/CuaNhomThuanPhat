@extends('frontend.layouts.master')
@section('content')
<main class="main checkout">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Thanh toán</span>
            </div>
            <h1 class="page-title title-cate">Thanh toán</h1>
        </div>
    </section>
    <div class="container">
        <form action="{{route('home.checkout.post')}}" method="post">
            <div class="row mt-4 gx-5">
                <div class="col-lg-8 checkout-main">
                    <div class="checkout-section">
                        <div class="section-head">
                            <h2>Địa chỉ giao hàng</h2>
                            <div class="desc">
                                Bạn vui lòng nhập thông tin dưới, nhân
                                viên sẽ gọi lại ngay để xác nhận đơn hàng và tiến hành giao hàng.
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="form-group">
                                <div class="label">Họ và tên</div>
                                <div class="field">
                                    <input type="text" name="name" class="form-control" value="{{old('name', Auth::guard('customer')->user()->name)}}" placeholder="Nhập họ và tên">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Email</div>
                                <div class="field">
                                    <input type="email" name="email" class="form-control" value="{{old('email', Auth::guard('customer')->user()->email)}}" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Số điện thoại<br>(bắt buộc)</div>
                                <div class="field">
                                    <input type="tel" name="phone" class="form-control" value="{{old('phone', Auth::guard('customer')->user()->phone)}}" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Tỉnh/ Thành phố</div>
                                <div class="field">
                                    <select name="city_id" id="city_field" class="form-select text-capitalize">
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        @if (isset($vtpost_city['message']) && $vtpost_city['message'] == 'OK')
                                            @foreach($vtpost_city['data'] as $item)
                                                <option value="{{$item['PROVINCE_ID']}}" {{ old('city_id') == $item['PROVINCE_ID']?'selected':'' }}>{{$item['PROVINCE_NAME']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Quận Huyện</div>
                                <div class="field">
                                    <select name="district_id" id="district_field" class="form-select text-capitalize" disabled>
                                        <option value="" selected disabled>Chọn Quận/Huyện</option>
                                        {{-- @if (isset($vtpost_districts['message']) && $vtpost_districts['message'] == 'OK')
                                            @foreach($vtpost_districts['data'] as $item)
                                                <option value="{{$item['DISTRICT_ID']}}" {{ old('district_id', $selected_district) == $item['DISTRICT_ID']?'selected':'' }}>{{ucwords(\Str::lower($item['DISTRICT_NAME']))}}</option>
                                            @endforeach
                                        @endif --}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Phường Xã</div>
                                <div class="field">
                                    <select name="ward_id" id="ward_field" class="form-select text-capitalize" disabled>
                                        <option value="" selected disabled>Chọn Phường/Xã</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Địa chỉ</div>
                                <div class="field">
                                    <textarea name="address" id="" cols="30" rows="4" class="form-control"
                                        placeholder="Nhập địa chỉ">{{ old('address') }}</textarea>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label">Ghi chú</div>
                                <div class="field">
                                    <textarea name="note" id="" cols="30" rows="4" class="form-control"
                                        placeholder="Nhập ghi chú">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-section mb-0">
                        <div class="section-head">
                            <h2>Phương thức vận chuyển</h2>
                        </div>
                        <div class="section-content payment-method">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="shipping" id="shipping" checked>
                                <label class="form-check-label" for="shipping">
                                    Giao hàng Viettel Post - Vận chuyển nhanh (không giao hàng vào thứ 7, chủ nhật)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-section mt-4">
                        <div class="section-head">
                            <h2>Phương thức thanh toán</h2>
                        </div>
                        <div class="section-content payment-method">
                            <div class="form-check">
                                <input class="form-check-input" type="radio"value="1" name="payment_type" id="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Thanh toán bằng tiền mặt khi nhận hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="2" name="payment_type" id="banking" {{ $banks->count() == 0 ? 'disabled':''}}>
                                <label class="form-check-label" for="banking">
                                    Chuyển khoản
                                </label>
                            </div>
                            @if($banks->count() > 0)
                            @foreach ($banks as $bank)
                            <div class="payment-info">
                                <div class="text">Bạn vui lòng chuyển khoản qua thông tin sau:</div>
                                <ul class="payment-detail list-unstyled mb-0">
                                    <li>
                                        <span>Tên tài khoản</span>
                                        <strong>{{$bank->name}}</strong>
                                    </li>
                                    <li>
                                        <span>Số tài khoản</span>
                                        <strong>{{$bank->number}}</strong>
                                    </li>
                                    <li>
                                        <span>Ngân hàng</span>
                                        <strong>{{$bank->bank}}</strong>
                                    </li>
                                    <li>
                                        <span>Cú pháp</span>
                                        <strong>{{$bank->mess}}</strong>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                            @endif
                            <div class="form-check">
                                <input class="form-check-input" type="radio"value="3" name="payment_type" id="vnpay">
                                <label class="form-check-label" for="vnpay">
                                    Thanh toán VNPAY (QR Code, Ví VNPay, Credit Card)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 checkout-sidebar">
                    <div class="sb-box">
                        <div class="sb-box-header">
                            <h3>Danh sách sản phẩm</h3>
                            <a href="{{ route('home.cart')}}">Thay đổi</a>
                        </div>
                        <div class="sb-box-content">
                            @foreach ($dataCart as $item)
                            <div class="sb-item">
                                <a href="{{route('home.product_single', $item->options->slug)}}" class="product">
                                    <img src="{{url(''.$item->options->image)}}" alt="">
                                    <span class="title">
                                        {{ $item->name }} {{ $item->options->product_value ? '('.$item->options->product_value.')' : ''}}
                                    </span>
                                </a>
                                <div class="price">
                                    <div class="amout">{{ number_format($item->price, 0, 3, '.') }} đ</div>
                                    <div class="quantity">x{{ $item->qty }}</div>
                                    <div class="total">{{ number_format($item->price*$item->qty, 0, 3, '.') }} đ</div>
                                </div>
                            </div>
                            @endforeach

                            <div class="sb-summary">
                                <div class="left">
                                    Tổng tiền hàng<br>
                                    ({{$dataCart->count()}} sản phẩm)
                                </div>
                                <div class="right">
                                    {{ Cart::instance('shopping')->priceTotal(0, 3, '.') }} đ
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sb-box">
                        <div class="sb-box-header">
                            <h3>Quà tặng <small>(nếu có)</small></h3>
                        </div>
                        <div class="sb-box-content">
                            @php $count = 0 @endphp
                            @foreach ($dataCart as $item)
                                @php
                                    $getBonusProduct = getProductBonus($item->id, $item->qty);
                                    $count += count($getBonusProduct);
                                @endphp
                                @if (count($getBonusProduct))
                                    <div class="sb-item">
                                        <div class="cart-gift">
                                            <div class="cart-gift-title">
                                                <i class="fa fa-gift"
                                                    aria-hidden="true"></i><span> Sản phẩm tặng kèm - {{ $item->name }}</span>
                                            </div>
                                            <div class="cart-gift-list">
                                                @foreach ($getBonusProduct as $bonus)
                                                <div class="cart-gift-item">
                                                    <a href="javascript:void(0)" class="cart-gift-thumb">
                                                        <img src="{{ url($bonus->product->image) }}" alt="" /></a>
                                                    <div class="cart-gift-info">
                                                        <div class="info-title">
                                                            <a href="javascript:void(0)"
                                                            title="{{ $bonus->product->name }}">{{ $bonus->product->name }}</a>
                                                        </div>
                                                        <span>Số lượng: {{ $bonus->bonus_quantity }} khi mua từ {{ $bonus->min_required }} sản phẩm</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endif
                            @endforeach
                            @if ($count > 0)
                                <div class="sb-summary">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"value="1" name="receive_gifts" id="receive_gifts" @if(session()->has('coupon')) disabled @else checked @endif>
                                        <label class="form-check-label" for="receive_gifts">
                                            Nhận sản phẩm khuyến mãi <small>(bỏ chọn nếu muốn áp dụng mã giảm giá)</small>
                                        </label>
                                    </div>
                                </div>
                            @else
                            <div class="sb-summary">
                                <span>Chưa có sản phẩm khuyến mãi</span>
                            </div>    
                            @endif
                            
                        </div>
                    </div>

                    <div class="sb-box">
                        <div class="sb-box-header">
                            <h3>Đơn Hàng</h3>
                        </div>
                        <div class="sb-box-content">
                            <div class="order-summary">
                                <div class="left">
                                    Tổng tiền hàng<br>
                                    ({{$dataCart->count()}} sản phẩm)
                                </div>
                                <div class="right">{{ Cart::instance('shopping')->priceTotal(0, 3, '.') }} ₫</div>

                                <div class="left">
                                    ViettelPost - VCN
                                </div>
                                <div class="right shipping_fee">0 ₫</div>

                                <div class="left">
                                    Giảm giá
                                </div>
                                <div class="right discount">0 ₫</div>

                                <div class="left">
                                    Chiết khấu <small>(đối tác)</small>
                                </div>
                                <div class="right cus_discount">{{ number_format($customer_discount, 0, 3, '.') }} ₫</div>
                            </div>

                            <div class="sb-summary py-4">
                                <div class="left">
                                    Tổng thanh toán
                                </div>
                                <div class="right total_checkout">
                                    {{ number_format(round(Cart::instance('shopping')->priceTotal(0, 3, false)-$customer_discount), 0, 3, '.') }} ₫
                                </div>
                            </div>

                            <div class="checkout">
                                <a href="javascript:void(0)" type="submit" class="btn btn-secondary btn_send_checkout">
                                    Đặt Hàng
                                </a>
                            </div>

                        </div>
                    </div>
                    
                    <div class="sb-box">
                        <div class="sb-box-header">
                            <h3>Mã giới thiệu</h3>
                        </div>
                        <div class="sb-box-content">
                            <div class="sb-summary py-4">
                                <div class="input-group coupon">
                                    <input type="text" class="form-control" placeholder="Nhập mã giới thiệu" {{ session()->has('referral')?'readonly':'' }}
                                        id="referral_code" aria-label="Mã giới thiệu" aria-describedby="btn_apply_referral" value="{{ session()->has('referral') ? session()->get('referral') : '' }}">
                                    <a href="javascript:void(0)" class="btn btn-secondary" type="button" id="btn_apply_referral" data-action="{{ session()->has('referral')?'remove':'apply' }}">
                                        @if (session()->has('referral'))
                                        <span class="lb_addcart">Xoá</span>
                                        @else
                                        <span class="lb_addcart">Áp dụng</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sb-box">
                        <div class="sb-box-header">
                            <h3>Mã giảm giá</h3>
                        </div>
                        <div class="sb-box-content">
                            <div class="sb-summary py-4">
                                <div class="input-group coupon">
                                    <input type="text" class="form-control" placeholder="Nhập mã giảm giá" {{ session()->has('coupon')?'readonly':'' }}
                                        id="coupon_code" aria-label="Mã giảm giá" aria-describedby="btn_apply_coupon" value="{{ session()->has('coupon') ? session()->get('coupon')['code'] : '' }}">
                                    <a href="javascript:void(0)" class="btn btn-secondary" type="button" id="btn_apply_coupon" data-action="{{ session()->has('coupon')?'remove':'apply' }}">
                                        @if (session()->has('coupon'))
                                        <span class="lb_addcart">Xoá</span>
                                        @else
                                        <span class="lb_addcart">Áp dụng</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</main>
@stop