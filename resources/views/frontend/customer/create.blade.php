@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="index.html">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Tạo tài khoản thành viên</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-change-pass account-update-info">
                    <h3>Tạo tài khoản thành viên</h3>
                    <form action="{{ route('home.customer.create.post') }}" method="POST" autocomplete="off">
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Họ và tên</label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập họ và tên" value="{{old('name')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Nhập email" value="{{old('mail')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" placeholder="Nhập số điện thoại" value="{{old('phone')}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Loại tài khoản</label>
                            <select class="form-select" name="customer_role_id" id="">
                                <option value="">Chọn</option>
                                @foreach ($role as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group password-field mb-3">
                            <label class="d-block mb-1">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                            <div class="show-password">
                                <span class="ic-eye-slashed"></span>
                            </div>
                        </div>
                        <div class="form-group password-field mb-3">
                            <label class="d-block mb-1">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu">
                            <div class="show-password">
                                <span class="ic-eye-slashed"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="d-block mb-1">Avatar</label>
                            <input type="file" class="form-control avatar-input" name="image">
                            <div class="avatar-preview">
                                <img src="{{asset('backend/images/default.jpg')}}" alt="avatar">
                            </div>
                        </div>
                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-primary btn_create_customer">Thêm thành viên</button>
                        </div>
                        
                    </form>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
