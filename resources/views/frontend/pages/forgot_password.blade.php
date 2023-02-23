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
        <form method="" action="{{ route('home.forgot_password.post') }}" class="lgi-page-form">
            <div class="form-group">
                <label for="">Email<span>*</span></label>
                <input type="text" placeholder="Nhập email..." name="email" class="form-control">
            </div>
            <p id="thongbaoquenmatkhau"></p>
            
            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn_forgot_password">Quên Mật Khẩu</button>
            </div>
            <div class="form-text">
                Bạn đã biết đến dotiva.vn? <a href="{{ route('home.login') }}">Đăng Nhập Ngay</a>
            </div>
        </form>
    </div>
</main>
@stop
