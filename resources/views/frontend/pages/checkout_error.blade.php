@extends('frontend.layouts.master')
@section('content')
<main class="main checkout">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Đặt hàng</span>
            </div>
            <h1 class="page-title title-cate">Đặt hàng thất bại</h1>
        </div>
    </section>
    <div class="container">
        <div class="checkout-section checkout-success">
            <div class="section-head">
                <h2>Xác nhận đặt hàng</h2>
            </div>
            <div class="section-content">
                <h1 class="text-danger">Đặt hàng không thành công!</h1>
                <p>
                    Có lỗi trong quá trình thanh toán hoặc đặt hàng, vui lòng thử lại hoặc liên hệ ngay với Dotiva để xử lý, xin cảm ơn!
                </p>
                <div class="icon">
                    <svg width="80" height="80" fill="#dc3545" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"/></svg>
                </div>
                <div class="action">
                    <a href="{{route('home.index')}}">Xác Nhận</a>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
