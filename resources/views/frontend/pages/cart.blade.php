@extends('frontend.layouts.master')
@section('content')
<main class="main cart">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Giỏ hàng</span>
            </div>
            <h1 class="page-title title-cate">Giỏ hàng</h1>
        </div>
    </section>
    <section class="cart-main mt-5">
        <div class="container">
            <div class="cart-table" id="cart_full_content">
                @if($dataCart->count() > 0)
                    @include('frontend.ajax.get_full_cart', ['dataCart' => $dataCart])
                @else
                    @include('frontend.ajax.get_cart_none')
                @endif
            </div>
        </div>
    </section>

</main>
@stop
