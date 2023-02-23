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
        <form method="POST" action="{{ route('home.update_password.post', $code) }}" class="lgi-page-form">
            @csrf
            <div class="form-group">
                <label for="">Mật khẩu mới <span>*</span></label>
                <input type="password" placeholder="Nhập mật khẩu mới" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Nhập lại mật khẩu mới <span>*</span></label>
                <input type="password" placeholder="Nhập lại mật khẩu mới" name="re_password" class="form-control">
            </div>

            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn_update_password">Thay Đổi Mật Khẩu</button>
            </div>
            <div class="form-text">
                Bạn đã biết đến Dotiva.vn? <a href="{{ route('home.login') }}">Đăng Nhập Ngay</a>
            </div>
        </form>
    </div>
</main>
@stop
