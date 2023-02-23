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
        <form   action="{{route('home.login.post')}}" method="" class="lgi-page-form">
            <div class="form-group">
                <label for="">Số điện thoại hoặc email <span>*</span></label>
                <input type="text" placeholder="Nhập email..." name="username" class="form-control">
            </div>
            <p id="thongbaousername"></p>
            <div class="form-group password-field">
                <label for="">Mật khẩu <span>*</span></label>
                <input type="password" placeholder="Nhập mật khẩu..." name="password" class="form-control">
                <div class="show-password">
                    <span class="ic-eye-slashed"></span>
                </div>
            </div>
            <p id="thongbaopassword"></p>
            <p id="thongbaologin"></p>

            <p>
            @if(Session::has('success'))
                <span style="color:#61E1BB;" class="fr-error d-block mt-1"><i class="fas fa-check-circle"></i> {{Session::get('success')}}</span>
                @php
                Session::forget('success');
                @endphp
            @endif
            </p>
            <div class="form-group form-action">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember_login">
                    <label for="remember_login" class="form-check-label">Ghi nhớ tôi lần sau</label>
                </div>
                <div class="form-link">
                    <a href="{{ route('home.forgot_password') }}">Bạn quên mật khẩu?</a>
                </div>
            </div>
            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn_login">
                       Đăng nhập
                </button>
            </div>
            <div class="form-text">
                Bạn mới biết đến Dotiva? <a href="{{ route('home.register') }}">Đăng Ký Ngay</a>
            </div>
            {{-- <div class="divide-text">
                <span>Hoặc đăng nhập bằng</span>
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
            {{-- <div class="form-text text-start mt-4">
                <i class="fas fa-exclamation-circle text-danger"></i> Bạn đã đăng ký nhưng chưa xác nhận. Vui lòng đăng nhập để xác nhận hoặc <a href="{{ route('home.email.verify') }}">xác nhận bằng email</a>
            </div> --}}
        </form>
    </div>
</main>
@section('script')
<script>
   
</script>
@endsection
@stop
