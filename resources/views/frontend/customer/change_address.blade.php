@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Cập nhật địa chỉ</span>
            </div>
            <h1 class="page-title title-cate">Cập nhật địa chỉ</h1>
        </div>
    </section>
    <div class="container">
        <div class="row mt-5 mb-3">

            @include('frontend.customer.sidebar')
        
            <div class="col-lg-8">
                <section class="account-section account-add-address">
                    <h3>Cập nhật thông tin địa chỉ</h3>
                    <form action="{{ route('home.customer.update_address.post', $address->id) }}" method="">
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Họ và tên</label>
                            <input type="text" class="form-control" name="name" value="{{$address->name}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" value="{{$address->phone}}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Loại địa chỉ</label>
                            <select name="type" class="form-select" id="type">
                                <option @if($address->type == 0) selected @endif value="0" >Nhà</option>
                                <option @if($address->type == 1) selected @endif value="1">Công ty</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Tỉnh/Thành phố</label>
                            <select name="city_id" class="form-select text-capitalize" id="city_field">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                @if (isset($vtpost_city['message']) && $vtpost_city['message'] == 'OK')
                                    @foreach($vtpost_city['data'] as $item)
                                        <option value="{{$item['PROVINCE_ID']}}" {{ old('city_id', $address->city_id) == $item['PROVINCE_ID'] ? 'selected':'' }}>{{$item['PROVINCE_NAME']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Quận huyện</label>
                            <select  name="district_id" class="form-select text-capitalize" id="district_field">
                                <option value="">Chọn Quận/Huyện</option>
                                @if (isset($vtpost_district['message']) && $vtpost_district['message'] == 'OK')
                                    @foreach($vtpost_district['data'] as $item)
                                        <option value="{{$item['DISTRICT_ID']}}" {{ old('district_id', $address->district_id) == $item['DISTRICT_ID'] ? 'selected':'' }}>{{(\Str::lower($item['DISTRICT_NAME']))}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Phường xã</label>
                            <select  name="ward_id" class="form-select text-capitalize" id="ward_field">
                                <option value="">Chọn Phường/Xã</option>
                                @if (isset($vtpost_ward['message']) && $vtpost_ward['message'] == 'OK')
                                    @foreach($vtpost_ward['data'] as $item)
                                        <option value="{{$item['WARDS_ID']}}" {{ old('district_id', $address->ward_id) == $item['WARDS_ID'] ? 'selected':'' }}>{{(\Str::lower($item['WARDS_NAME']))}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="d-block mb-1">Địa chỉ</label>
                            <textarea name="address" id="" cols="30" rows="2" class="form-control">{{$address->address}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" id="default" value="1" @if($address->is_default == 1) checked @endif>
                                <label class="form-check-label fw-normal fs-6" for="default">
                                    Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                        </div>
                        <div class="form-submit mt-4">
                            <button type="submit" class="btn btn-primary btn_capnhatdiachi">Cập nhật</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
