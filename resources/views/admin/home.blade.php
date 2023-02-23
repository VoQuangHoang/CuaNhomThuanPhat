@extends('admin.layouts.app')
@section('controller','Dashboard')
@section('controller_route', route('admin.home'))
@section('action','')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fab fa-product-hunt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sản phẩm</span>
                    <span class="info-box-number">
                        {{$products->count()}}
                    </span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Đơn hàng</span>
                    <span class="info-box-number">{{$orders->count()}}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Người dùng</span>
                    <span class="info-box-number">{{$users->count()}}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="far fa-address-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Liên hệ</span>
                    <span class="info-box-number">{{$contacts->count()}}</span>
                </div>
            </div>
        </div>

    </div>
    <div>
        <h2>Chat box</h2>
        <ul id="messages" class="list-group"></ul>
      </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sản phẩm mới</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($products as $item)
                            @if ($loop->index <= 5)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{$item->image}}" alt="Product Image" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$item->name}}
                                        <span class="badge badge-info float-right">Thương hiệu: {{$item->name}}</span></a>
                                    <span class="product-description">
                                        @foreach ($item->Category as $cate)
                                            <span class="badge badge-info">{{$cate->name}}</span><br>
                                        @endforeach
                                    </span>
                                </div>
                            </li>
                            @endif
                        @endforeach                     
                    </ul>
                </div>

                <div class="card-footer text-center" style="display: block;">
                    <a href="{{route('products.index')}}" class="uppercase">Xem tất cả sản phẩm</a>
                </div>

            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Đơn hàng mới</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($orders as $item)
                            @if ($loop->index <= 5)
                                <li class="item">
                                    <div class="product-img">
                                        <img src="{{url('/images/nocart.png')}}" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">{{!empty($item->name) ? $item->name : $item->Customer->name}}
                                            <div class="float-right">
                                                {!! $item->getStatusOrder($item->payment_type, $item->status) !!}
                                            </div>
                                        </a>
                                        <span class="product-description">
                                            Mã đơn: {{$item->sku}} - Giá: {{$item->total_price}}đ
                                        </span>
                                    </div>
                                </li>
                            @endif    
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer text-center">
                    <a href="{{route('admin.order.list')}}" class="uppercase">Xem tất cả hóa đơn</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
