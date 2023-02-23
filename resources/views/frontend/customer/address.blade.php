@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Sổ địa chỉ</span>
            </div>
            <h1 class="page-title title-cate">Sổ địa chỉ</h1>
        </div>
    </section>
    <div class="container">
        <div class="row mt-5 mb-3">
            @include('frontend.customer.sidebar')
            <div class="col-lg-8">
                <section class="account-section account-address">
                    <h3>Sổ địa chỉ</h3>
                    <div class="address-list">
                        @foreach($address as $item)
                        <div class="address-item">
                            <div class="title">{{$item->name}} - {{$item->phone}}
                                @if($item->type == 0)
                                    (Nhà riêng)
                                @else
                                    (Công ty)
                                @endif
                            </div>
                            <div class="detail">
                                {!! getFullAddressVTP($item) !!}
                            </div>

                            @if($item->is_default == 1 )
                                <div class="default">
                                    Địa chỉ mặc định
                                </div>
                            @else
                            <div class="action">
                                <a href="javascript:void(0);"></a>
                                <div class="action-box">
                                    <a href="{{ route('home.customer.set_address_default', $item->id) }}">Đặt làm mặc định</a>
                                    <a href="{{ route('home.customer.update_address',  $item->id) }}">Chỉnh sửa</a>
                                    <a href="{{ route('home.customer.delete_address',  $item->id) }}">Xoá</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach

                    </div>
                    <nav class="page-pagination customer-list mt-2">
                        {!! $address->links('vendor.pagination.bootstrap-5') !!}
                    </nav>
                </section>
                <section class="account-section account-add-address">
                    <h3>Thêm địa chỉ</h3>
                    <form action="{{ route('home.customer.address.post') }}" method="POST">
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Họ và tên</label>
                            <input type="text" class="form-control" name="name" value="{{Auth::guard('customer')->user()->name}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Loại địa chỉ</label>
                            <select name="type" class="form-select" id="type">
                                <option value="0" >Nhà riêng</option>
                                <option value="1">Công ty</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Tỉnh/Thành phố</label>
                            <select name="city_id" id="city_field" class="form-select text-capitalize">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                @if (isset($vtpost_city['message']) && $vtpost_city['message'] == 'OK')
                                    @foreach($vtpost_city['data'] as $item)
                                        <option value="{{$item['PROVINCE_ID']}}" {{ old('city_id') == $item['PROVINCE_ID'] ? 'selected':'' }}>{{$item['PROVINCE_NAME']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Quận/Huyện</label>
                            <select name="district_id" id="district_field" class="form-select text-capitalize" disabled>
                                <option value="" selected disabled>Chọn Quận/Huyện</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Phường/Xã</label>
                            <select name="ward_id" id="ward_field" class="form-select text-capitalize" disabled>
                                <option value="" selected disabled>Chọn Phường/Xã</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Địa chỉ</label>
                            <textarea name="address" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" id="default" value="1">
                                <label class="form-check-label fw-normal fs-6" for="default">
                                    Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                        </div>
                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-primary btn_themdiachi">Thêm địa chỉ</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
