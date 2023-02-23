@extends('frontend.master')
@section('main')
<div class="content">
    <div class="wp-breadcumb">
        <nav aria-label="breadcrumb">
            <div class="container">
                <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home.index') }}"><img srcset="{{ asset('frontend/img/icon/home.png 2x') }}" alt="" /></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Thanh toán
                    </li>
                </ol>
            </div>
        </nav>
    </div>

    <div class="payment-success">
        <div class="container">
            <div class="payment-success-inner">
                <div class="products-title">
                    <h3>Xác nhận thanh toán</h3>
                </div>
                <div class="payment-success-content br-bottom-8 bg-white p-16">
                    <h1 class="title">Đặt hàng thành công!</h1>
                    <p class="subtitle">Cảm ơn bạn đã tin tưởng vào dịch vụ của chúng tôi, đơn hàng sẽ đến tay
                        bạn trong
                        thời gian sớm nhất, xin cảm ơn!</p>
                    <img srcset="{{ asset('frontend/img/icon/checked.png 2x') }}" alt="">
                    <a href="{{ route('home.index') }}" class="confirm">Trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
