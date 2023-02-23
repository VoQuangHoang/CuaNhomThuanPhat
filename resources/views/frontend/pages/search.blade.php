@extends('frontend.layouts.master')
@section('quickview')
    @include('frontend.layouts.quickview')
@endsection
@section('content')
<main class="site-main product-listing">
    <section class="page-heading" style="background-image:url({{asset('images/product-listing-banner.jpg')}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Tìm kiếm</span>
            </div>
            <h1 class="page-title">Kết quả tìm kiếm cho <span class="text-lowercase">{{Request::get('k') != '' ? ': "'.Request::get('k').'"' : ''}}</span></h1>
        </div>
    </section>

    <section class="product-listing-container">
        <div class="container">
            <div class="row">
                @if(count($data) > 0)
                <div class="col-lg-12">
                    
                    <div class="product-sorting">
                        <div class="layout-view">
                            <a href="javascript:void(0);" class="grid_view active" data-href="grid">
                                <img src="{{asset('images/icon/ic-grid.svg')}}" alt="icon">
                                <img src="{{asset('images/icon/ic-grid-active.svg')}}" alt="icon">
                            </a>
                            <a href="javascript:void(0);" class="list_view" data-href="list">
                                <img src="{{asset('images/icon/ic-list.svg')}}" alt="icon">
                                <img src="{{asset('images/icon/ic-list-active.svg')}}" alt="icon">
                            </a>
                        </div>
                    </div>
                    <div class="product-wrap grid">
                        @foreach ($data as $item)
                        <div class="product-item">
                            <div class="thumb-box">
                                @if ($item->price_sale > 0)
                                <div class="sale">-{{round(($item->price-$item->price_sale) / $item->price ,2)*100}}%</div>
                                @endif
                                <div class="image">
                                    <a href="{{route('home.product_single', $item->slug)}}">
                                        @if (!empty($item->more_image))
                                        @foreach (json_decode($item->more_image) as $image)
                                            @if ($loop->index == 0)
                                                <img src="{{asset($image->image)}}" alt="{{$image->text}}" class="second-thumbnail">   
                                            @endif
                                        @endforeach
                                        @endif
                                        <img src="{{asset($item->image)}}" alt="{{$item->name}}">
                                    </a>
                                </div>
                                <div class="action">
                                    <form action="{{route('home.cart.add')}}" method="post">
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="quantity" value="1" min="1" readonly>
                                        <input type="hidden" name="type" value="1">
                                        <a href="javascript:void(0);" class="add-to-cart"></a>
                                    </form>
                                    <a href="javascript:void(0);" data-slug={{$item->slug}} class="quick-view"><i class="far fa-eye"></i></a>
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" class="add-to-wishlist {{in_array($item->id, $list_pro_wishlist) ? 'active' : ''}} add_to_wishlist" id="item-wishlist-{{$item->id}}"><i class="far fa-heart"></i></a>
                                </div>
                            </div>
                            <div class="info-box">
                                <div class="category"><a href="{{route('home.product_cate_single', $item->Category[0]->slug)}}">{{$item->Category[0]->name}}</a></div>
                                <div class="title limit-text-2">
                                    <a href="{{route('home.product_single', $item->slug)}}">{{$item->name}}</a>
                                </div>
                            </div>
                            <div class="price-box">
                                @if ($item->price_sale > 0)
                                    <div class="main-price me-3">{{number_format($item->price_sale, 0,3,'.')}} ₫</div>
                                    <div class="old-price">
                                        <del>{{number_format($item->price, 0,3,'.')}} ₫</del>
                                    </div>
                                @else
                                    <div class="main-price me-3">{{number_format($item->price, 0,3,'.')}} ₫</div>
                                @endif
                            </div>
                            <div class="short-desc limit-text-2">
                                {!! $item->short_desc !!}
                            </div>
                            <div class="list-view-action">
                                <form action="{{route('home.cart.add')}}" method="post">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <input type="hidden" name="quantity" value="1" min="1" readonly>
                                    <input type="hidden" name="type" value="1">
                                    <a href="javascript:void(0);" class="add-to-cart">Thêm vào giỏ hàng</a>
                                </form>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <nav class="page-pagination">
                        {{ $data->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                    
                </div>
                @else
                        <span style="height: 400px !important">Không có sản phẩm cho từ khóa này</span>
                    @endif
            </div>
        </div>
    </section>

</main>
@stop