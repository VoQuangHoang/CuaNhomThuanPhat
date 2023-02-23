@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Tài khoản</span>
            </div>
            <h1 class="page-title title-cate">Cập nhật thông tin</h1>
        </div>
    </section>
    <div class="container">
        <div class="row mt-5 mb-3">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-update-info">
                    <h3>Cập nhật thông tin tài khoản</h3>
                    <form id="ajax_updateinfo" action="{{ route('home.customer.post_info_update')}}" method=""  enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Họ và tên</label>
                            <input type="text" class="form-control" name="name" value="{{$customer->name}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Email</label>
                            <input type="email" class="form-control" name="email" value="{{$customer->email}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" value="{{$customer->phone}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="d-block mb-1">Avatar</label>
                            <input type="file" class="form-control avatar-input" name="avatar">
                            <div class="avatar-preview">
                                <img src="
                                @if(Auth::guard('customer')->user()->image == null)
                                    {{asset('backend/images/default.jpg')}}
                                @else
                                    {{asset('frontend/avatar/'.Auth::guard('customer')->user()->image)}}
                                @endif
                                " alt="avatar">
                            </div>
                        </div>
                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-primary btn_updateinfo">Cập Nhật</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
