@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="index.html">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Tài khoản</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-change-pass">
                    <h3>Thay đổi mật khẩu</h3>
                    <form action="{{ route('home.customer.postchange_pass') }}" method="">
                        <div class="form-group password-field mb-3">
                            <label class="d-block mb-1">Mật khẩu hiện tại</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu hiện tại">
                            <div class="show-password password">
                                <span class="ic-eye-slashed"></span>
                            </div>
                        </div>
                        <div class="form-group password-field mb-3">
                            <label class="d-block mb-1">Mật khẩu mới</label>
                            <input type="password" name="password_new" class="form-control" placeholder="Nhập mật khẩu mới">
                            <div class="show-password password_new">
                                <span class="ic-eye-slashed"></span>
                            </div>
                        </div>
                        <div class="form-group password-field mb-3">
                            <label class="d-block mb-1">Xác nhận mật khẩu</label>
                            <input type="password" name="password_new_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                            <div class="show-password password_new_confirmation">
                                <span class="ic-eye-slashed"></span>
                            </div>
                        </div>
                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-primary btn_thaydoimatkhau">Cập nhật</button>
                        </div>
                        
                    </form>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
