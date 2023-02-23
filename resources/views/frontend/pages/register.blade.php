@extends('frontend.layouts.master')
@section('content')
<main class="main lgi-page">
    <section class="page-heading" style="background-image:url({{asset($contentPage->header->image)}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">{{$contentPage->header->h1}}</span>
            </div>
            <h1 class="page-title">{{$contentPage->header->h1}}</h1>
        </div>
    </section>
    <div class="lgi-page-box">
        <form method="post" action="{{ route('home.register.post') }}" class="lgi-page-form">
            <div class="form-group">
                <label for="">Họ và tên <span>*</span></label>
                <input type="text" placeholder="Nhập tên..." name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Số điện thoại<span>*</span></label>
                <input type="text" placeholder="Nhập số điện thoại..." id="phone" name="phone" class="form-control">
            </div>

            <div class="form-group">
                <label for="">Email <span>*</span></label>
                <input type="text" placeholder="Nhập email..." name="email" class="form-control" autocomplete="off">
            </div>
            <div class="form-group password-field">
                <label for="">Mật khẩu <span>*</span></label>
                <input type="password" placeholder="Nhập mật khẩu..." name="password" class="form-control">
                <div class="show-password password">
                    <span class="ic-eye-slashed"></span>
                </div>
            </div>
            <div class="form-group password-field">
                <label for="">Nhập lại mật khẩu <span>*</span></label>
                <input type="password" placeholder="Nhập lại mật khẩu..." name="password_confirmation" class="form-control">
                <div class="show-password password_confirmation">
                    <span class="ic-eye-slashed"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="">Mã giới thiệu <small>(nếu có)</small></label>
                <input type="text" placeholder="Nhập mã..." name="referral_code" class="form-control" autocomplete="off">
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="is_aff" value="1"> Tham gia Dotiva Affiliate <small>(Chương trình tiếp thị liên kết của Dotiva)</small>
                </label>
            </div>
            <p id="thongbaodangky"></p>
            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn_register">Đăng ký</button>
            </div>
            <div class="form-text">
                Bạn đã biết đến Dotiva? <a href="{{ route('home.login') }}">Đăng Nhập Ngay</a>
            </div>
            {{-- <div class="divide-text">
                <span>Hoặc đăng ký bằng</span>
            </div>
            <ul class="list-social list-unstyled mb-0">
                <li>
                    <a href="{{ url('auth/facebook') }}">
                        <i class="fab fa-facebook-f fs-4 text"></i> &nbsp;
                        Tài khoản Facebook
                    </a>
                </li>
                <li>
                    <a href="{{ url('auth/google') }}">
                        <i class="fab fa-google fs-4 text"></i> &nbsp;
                        Tài khoản Gmail
                    </a>
                </li>

            </ul> --}}
        </form>
    </div>
</main>
@stop
