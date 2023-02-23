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
                    <p class="price">{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',0)->where('status',1)->sum('aff_amount'), 0, 3, '.') }} ₫</p>
                    <div class="affiliate-price-item">
                        <h3>Số tiền trong trạng thái chờ</h3>
                        <p>{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',0)->where('status',0)->sum('aff_amount'), 0, 3, '.') }} ₫</p>
                    </div>
                    <div class="affiliate-price-item">
                        <h3>Số tiền hoa hồng đã rút</h3>
                        <p>{{ number_format(auth('customer')->user()->aff_sales()->where('withdraw',1)->where('status',1)->sum('aff_amount'), 0, '', '.') }} ₫</p>
                    </div>
                    <a href="{{route('home.affiliate.request')}}" class="request-payment">Gửi yêu cầu thanh toán</a>
                </div>
                {{-- <div class="affiliate-menu">
                    <a href="" class="affiliate-menu-link">Tài khoản</a>
                    <a href="" class="affiliate-menu-link">Hướng dẫn chi tiết</a>
                    <a href="" class="affiliate-menu-link">Quy đổi sản phẩm</a>
                </div> --}}
            </div>
            <div class="affiliate-right">
                <div class="affiliate-statistical">
                    <div class="affiliate-statistical-item click">
                        <p>{{ $aff_click }}</p>
                        <span>Lượt click</span>
                        <i class="fas fa-plus-square"></i>
                    </div>
                    <div class="affiliate-statistical-item register">
                        <p>{{ auth('customer')->user()->aff_sales()->count() }}</p>
                        <span>Lượt đặt hàng</span>
                        <i class="fas fa-check-square"></i>
                    </div>
                    <div class="affiliate-statistical-item per">
                        <p>{{ $percent_click }}%</p>   
                        <span>Tỉ lệ <small>(qua link aff)</small></span>
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="affiliate-block">
                    <div class="affiliate-block-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Click để sao chép">
                        <span>Liên kết giới thiệu của bạn</span>
                        <a class="clipboard" data-ref="{{ route('home.get.afflink', ['aff' => Auth::guard('customer')->user()->aff_id]) }}">{{ route('home.get.afflink', ['aff' => Auth::guard('customer')->user()->aff_id]) }}</a>
                    </div>
                </div>
                <div class="affiliate-block">
                    <h4 class="title">Tham gia cộng đồng Affiliate tại Dotiva</h4>
                    <p class="subtitle">Tham gia cộng đồng Affiliate tại Dotiva trên Facebook Group để nhận được
                        thông báo mới
                        nhất và các chương trình ưu đãi và thông tin liên quan đến Affiliate.</p>
                    <div class="affiliate-block-link">
                        <span>Tham gia tại</span>
                        <a href="{{ $site_info->social->facebook }}" target="_blank">{{ $site_info->social->facebook }}</a>
                    </div>
                </div>
                <div class="affiliate-block instruct">
                    <p class="instruct-title">Bạn có thể tùy chỉnh liên kết trang đích chuyển tới của liên kết giới
                        thiệu
                        bằng cách thêm tham số
                        <span> url </span> phía sau. Ví dụ:
                    </p>
                    <div class="affiliate-block-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Click để sao chép">
                        <a class="clipboard"
                            data-ref="{{ route('home.get.afflink', ['aff' =>Auth::guard('customer')->user()->aff_id]).'&url=https://dotiva.vn/san-pham/kem-u-trang-body-v7'}}">{{ route('home.get.afflink', ['aff' => Auth::guard('customer')->user()->aff_id]).'&url=https://dotiva.vn/san-pham/kem-u-trang-body-v7' }}</a>
                    </div>
                </div>
                <div class="affiliate-table">
                    <div class="affiliate-table-title br-top-8">
                        <p>Thông tin chi tiết</p>
                        <form class="affiliate-table-search ">
                            <input type="text" placeholder="Tìm kiếm..">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="affiliate-table-inner">
                            <tr>
                                <th>Ngày đăng ký</th>
                                <th>Sản phẩm/dịch vụ</th>
                                <th>Số tiền</th>
                                <th>Hoa hồng</th>
                                <th>Tình trạng</th>
                            </tr>
                            @if(count($aff_sales)>0)
                                @foreach ($aff_sales as $sale)
                                <tr>
                                    <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        {{-- {{dd($sale->order)}} --}}
                                        <div class="product-service">
                                            @php
                                                $order_details = $sale->order->OrderDetail
                                            @endphp
                                            @foreach ($order_details as $detail)
                                                <p>{{ $detail->Product->name }}</p>
                                            @endforeach
                                            <p>Khách hàng: {{ $sale->order->name }}</p>
                                            <p>ID: {{ $sale->order->id }} - Mã đơn: {{ $sale->order->sku }}</p>
                                        </div>
                                    </td>
                                    <td>{{ number_format($sale->total_amount) }}đ</td>
                                    <td>{{ number_format($sale->aff_amount) }}đ</td>
                                    <td>{!! $sale->order->getStatusOrder($sale->order->payment_type,$sale->order->status) !!}</td>
                                </tr>
                                @endforeach
                                @if ($aff_sales->lastPage()>1)
                                <tr>
                                    <td colspan="5">
                                        <nav class="page-pagination customer-list mt-2">
                                            {!! $aff_sales->links('vendor.pagination.bootstrap-5') !!}
                                        </nav>
                                    </td>
                                </tr>
                                @endif
                            @else
                            <tr>
                                <td colspan="5">
                                    Chưa có đơn hàng nào
                                </td>
                            </tr>
                            @endif
                            
                        </table>
                    </div>

                </div>
                {{-- <div class="affiliate-link-us">
                    <h4 class="title">Liên kết với Dotiva</h4>
                    <img src="{{ asset('frontend/img/affi-1.png') }}" alt="">
                    <img src="{{ asset('frontend/img/affi-2.png') }}" alt="">
                    <img src="{{ asset('frontend/img/affi-3.png') }}" alt="">
                    <img src="{{ asset('frontend/img/affi-4.png') }}" alt="">
                </div> --}}
            </div>
        </div>

    </div>
</main>

@stop
