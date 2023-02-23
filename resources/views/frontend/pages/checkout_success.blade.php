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
            <h1 class="page-title title-cate">Đặt hàng thành công</h1>
        </div>
    </section>
    <div class="container">
        <div class="checkout-section checkout-success">
            <div class="section-head">
                <h2>Xác nhận đặt hàng</h2>
            </div>
            <div class="section-content">
                <h1>Đặt hàng thành công!</h1>
                <p>
                    Cảm ơn bạn đã tin tưởng vào dịch vụ của chúng tôi, đơn hàng sẽ đến tay bạn trong thời gian
                    sớm nhất, xin cảm ơn!
                </p>
                <div class="icon">
                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M50 0C40.111 0 30.444 2.93245 22.2215 8.42652C13.9991 13.9206 7.59043 21.7295 3.80605 30.8658C0.0216642 40.0021 -0.968502 50.0555 0.960758 59.7545C2.89002 69.4535 7.65206 78.3627 14.6447 85.3553C21.6373 92.3479 30.5465 97.11 40.2455 99.0392C49.9445 100.968 59.9979 99.9783 69.1342 96.194C78.2705 92.4096 86.0794 86.0009 91.5735 77.7785C97.0676 69.556 100 59.889 100 50C100 43.4339 98.7067 36.9321 96.194 30.8658C93.6812 24.7995 89.9983 19.2876 85.3553 14.6447C80.7124 10.0017 75.2005 6.31876 69.1342 3.80602C63.0679 1.29329 56.5661 0 50 0ZM40 75L15 50L22.05 42.95L40 60.85L77.95 22.9L85 30L40 75Z"
                            fill="#36A451" />
                    </svg>
                </div>
                <div class="action">
                    <a href="{{route('home.index')}}">Xác Nhận</a>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
