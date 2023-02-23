@extends('frontend.layouts.master')
@section('page_css')
    <link rel="stylesheet" href="{{asset('frontend/css/aff.css?v='.time())}}">
@endsection
@section('content')
<main class="main affiliate">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="index.html">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Affiliate</span>
        </div>
        
        <div class="affiliate-inner">
            <div class="affiliate-left">
                <div class="affiliate-price">
                    <div class="affiliate-title">
                        <h1 class="title">Số tiền hoa hồng hưởng được</h1>
                        @if (!empty($rank))
                        <div class="affiliate-type">
                            <img src="{{ asset('frontend/img/icon/rank-'.$rank.'.png') }}" alt="">
                            <div class="bg-type-mem">
                            <img src="{{ asset('frontend/img/icon/bg-type-mem.png') }}" alt="">
                            <span>Thành viên {{ $text_rank }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <p class="price">{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',0)->where('status',1)->sum('aff_amount'), 0, '', '.') }} ₫</p>
                    <div class="affiliate-price-item">
                        <h3>Số tiền trong trạng thái chờ</h3>
                        <p>{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',0)->where('status',0)->sum('aff_amount'), 0, '', '.') }} ₫</p>
                    </div>
                    <div class="affiliate-price-item">
                        <h3>Số tiền hoa hồng đã nhận</h3>
                        <p>{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',1)->where('status',1)->sum('aff_amount'), 0, '', '.') }} ₫</p>
                    </div>
                </div>
                {{-- <div class="affiliate-menu">
                    <a href="" class="affiliate-menu-link">Tài khoản</a>
                    <a href="" class="affiliate-menu-link">Hướng dẫn chi tiết</a>
                    <a href="" class="affiliate-menu-link">Quy đổi sản phẩm</a>
                </div> --}}
            </div>
            <form action="{{route('home.affiliate.post_request')}}" class="affiliate-right" method="POST">
                        @csrf
                        <div class="affiliate-form">
                            <div class="products-title">
                                <span>Gửi yêu cầu thanh toán</span>
                            </div>
                            <div class="affiliate-form-inner">
                                {{-- @if (session()->has('success'))
                                    <span class="fr-error mt-2 d-block">{{ session()->get('success') }}</span>
                                @endif --}}
                                {{-- <div class="d-flex w-100 justify-content-between flex-wrap">
                                    <div class="affiliate-form-field">
                                        <div class="field-inner">
                                            <label for="affiliate-name">Số dư hoa hồng hiện tại</label>
                                            <input type="text" readonly class="form-control" value="{{ number_format(auth('customer')->user()->current_aff_amount) }}">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="d-flex w-100 justify-content-between flex-wrap">
                                    <div class="affiliate-form-field">
                                        <div class="field-inner">
                                            <label for="affiliate-name">Số tiền hoa hồng được nhận</label>
                                            <input type="text" readonly class="form-control" value="{{ number_format(auth('customer')->user()->aff_sales()->where('status',1)->where('withdraw',0)->sum('aff_amount'), 0, '', '.') }}">
                                            {{-- @if (session()->has('error'))
                                                <span class="fr-error mt-2 d-block">{{ session()->get('error') }}</span>
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex w-100 justify-content-between flex-wrap">
                                    <div class="affiliate-form-field">
                                        <div class="field-inner">
                                            <label for="affiliate-name">Hình thức rút tiền</label>
                                            <select class="form-control" name="request_type" id="request_type">
                                                <option value="bank_tranfer" {{ old('request_type') == 'bank_tranfer' ? 'selected':'' }}>Chuyển khoản ngân hàng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="block_request_bank" style="width: 100%">
                                    <div class="d-flex w-100 justify-content-between flex-wrap">
                                        <div class="affiliate-form-field">
                                            <div class="field-inner">
                                                <label for="affiliate-name">Ngân hàng</label>
                                                <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" placeholder="Vietcombank Đà Nẵng">
                                                @if($errors->has('bank_name'))
                                                    <span class="fr-error mt-2 d-block">{{ $errors->first('bank_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between flex-wrap">
                                        <div class="affiliate-form-field">
                                            <div class="field-inner">
                                                <label for="affiliate-name">Số tài khoản</label>
                                                <input type="text" class="form-control" name="bank_number" value="{{ old('bank_number') }}" placeholder="9999999999">
                                                @if($errors->has('bank_number'))
                                                    <span class="fr-error mt-2 d-block">{{ $errors->first('bank_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between flex-wrap">
                                        <div class="affiliate-form-field">
                                            <div class="field-inner">
                                                <label for="affiliate-name">Tên tài khoản</label>
                                                <input type="text" class="form-control" name="holder_name" value="{{ old('holder_name') }}" placeholder="NGUYEN VAN A">
                                                @if($errors->has('holder_name'))
                                                    <span class="fr-error mt-2 d-block">{{ $errors->first('holder_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="affiliate-form-btn">
                                        <button type="submit" class="affiliate-save">Gửi yêu cầu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
        </div>

    </div>
</main>

@stop
