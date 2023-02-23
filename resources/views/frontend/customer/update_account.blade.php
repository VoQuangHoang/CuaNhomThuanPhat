@extends('frontend.layouts.masters')
@section('content')
<main class="main lgi-page">
    <div class="lgi-page-box">
        <h1>Cập nhật thông tin</h1>
        <form action="{{ route('home.update.social') }}" method="post" class="lgi-page-form">
            @csrf
            <div class="form-group">
                <label for="">Họ và tên <span>*</span></label>
                <input type="text" placeholder="Nhập tên..." name="name" value={{$user->name}} class="form-control">
                <input type="hidden" name="code" value="{{$user->code}}">
            </div>
            <div class="form-group">
                <label for="">Số điện thoại<span>*</span></label>
                <input type="text" placeholder="Nhập số điện thoại..." autocomplete="off" name="phone" class="form-control">
            </div>
            <div class="form-group password-field">
                <label for="">Mật khẩu <span>*</span></label>
                <input type="password" placeholder="Nhập mật khẩu..." autocomplete="off" name="password" class="form-control">
                <div class="show-password">
                    <span class="ic-eye-slashed"></span>
                </div>
            </div>
            <div class="form-group password-field">
                <label for="">Nhập lại mật khẩu <span>*</span></label>
                <input type="password" placeholder="Nhập lại mật khẩu..." name="password_confirmation" class="form-control">
                <div class="show-password">
                    <span class="ic-eye-slashed"></span>
                </div>
            </div>
            <div class="form-submit">
                <button type="submit" class="btn btn-primary btn_update_social">Cập nhật</button>
            </div>
        </form>
    </div>
</main>
@stop
