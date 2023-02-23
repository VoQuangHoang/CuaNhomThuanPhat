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
                <a href="{{route('home.product_cate')}}">Danh mục</a>
            </div>
            <h1 class="page-title">Danh mục: {{$cateBySlug->name}}</h1>
        </div>
    </section>

    <section class="product-listing-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-filter filter-cate-product">
                        <div class="filter-mobile align-items-center justify-content-between mb-3">
                            <span>Lọc sản phẩm</span>
                            <div class="close-sidebar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div>
                        </div>
                        <h3 class="filter-title text-uppercase">Danh mục</h3>
                        <div class="filter-check">
                            <ul class="filter-check-nav-list">
                                @foreach ($categories as $cate)
                                <li class="filter-check-nav-list-item {{$cate->slug == $cateBySlug->slug ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        <a rel="nofollow" href="{{route('home.product_cate_single', $cate->slug)}}">{{$cate->name}}</a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <h3 class="filter-title text-uppercase">Giá</h3>
                        <form action="" method="get">
                        <input type="hidden" id="price_from" name="price_from" value="{{!empty(Request::get('price_from')) ? Request::get('price_from') : '0'}}">
                        <input type="hidden" id="price_to" name="price_to" value="{{!empty(Request::get('price_to')) ? Request::get('price_to') : '1000000'}}">
                        @if (!empty(Request::get('capacity')))
                            <input type="hidden" name="capacity" value="{{Request::get('capacity')}}">
                        @endif
                        @if (!empty(Request::get('brand')))
                            <input type="hidden" name="brand" value="{{Request::get('brand')}}">
                        @endif
                        @if (!empty(Request::get('stock')))
                            <input type="hidden" name="stock" value="{{Request::get('stock')}}">
                        @endif
                        @if (!empty(Request::get('sale')))
                            <input type="hidden" name="sale" value="{{Request::get('sale')}}">
                        @endif
                        @if (!empty(Request::get('sort')))
                            <input type="hidden" name="sort" value="{{Request::get('sort')}}">
                        @endif
                        {{-- <div class="color-selects">
                            <div class="color-item black"></div>
                            <div class="color-item blue"></div>
                            <div class="color-item brown active"></div>
                            <div class="color-item green"></div>
                            <div class="color-item orange"></div>
                            <div class="color-item red"></div>
                        </div> --}}
                        
                        <div id="slider-range" class="mt-4 mb-3"></div>
                        <div class="price_slider_amount d-flex flex-wrap align-items-center justify-content-between mb-4">
                            <div class="price_label" style="">
                                Giá: <span class="from">{{!empty(Request::get('price_from')) ? Request::get('price_from') : '0'}}</span> — <span class="to">{{!empty(Request::get('price_to')) ? Request::get('price_to') : '1000000'}}</span>
                            </div>
                            <button type="submit" class="btn btn-sm">Lọc</button>
                        </div>
                        </form>

                        <h3 class="filter-title text-uppercase">Thương hiệu</h3>
                        <div class="filter-check">
                            <ul class="filter-check-nav-list">
                                @foreach ($brands as $brand)
                                <li class="filter-check-nav-list-item {{Request::get('brand') == $brand->id ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        @if (Request::get('brand') == $brand->id)
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['brand' => NULL])}}">{{$brand->name}}</a>
                                        @else
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['brand' => $brand->id])}}">{{$brand->name}}</a>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <h3 class="filter-title text-uppercase">Dung tích</h3>
                        <div class="filter-check">
                            <ul class="filter-check-nav-list">
                                @foreach ($capacity as $cap)
                                <li class="filter-check-nav-list-item {{Request::get('capacity') == $cap->capacity ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        @if (Request::get('capacity') == $cap->capacity)
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['capacity' => NULL])}}">{{$cap->capacity}}ml</a>
                                        @else
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['capacity' => $cap->capacity])}}">{{$cap->capacity}}ml</a>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <h3 class="filter-title text-uppercase">Trạng thái hàng</h3>
                        <div class="filter-check">
                            <ul class="filter-check-nav-list">
                                <li class="filter-check-nav-list-item {{Request::get('stock') == 'in_stock' ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        @if (Request::get('stock') == 'in_stock')
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['stock' => NULL])}}">Còn hàng</a>
                                        @else
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['stock' => 'in_stock'])}}">Còn hàng</a>
                                        @endif
                                    </div>
                                </li>
                                {{-- <li class="filter-check-nav-list-item">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        <a rel="nofollow" href="">Tạm hết hàng</a>
                                    </div>
                                </li>
                                <li class="filter-check-nav-list-item active">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        <a rel="nofollow" href="">Ngừng kinh doanh</a>
                                    </div>
                                </li> --}}
                                <li class="filter-check-nav-list-item {{Request::get('sale') == 'in_sale' ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        @if (Request::get('sale') == 'in_sale')
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['sale' => NULL])}}">Đang giảm giá</a>
                                        @else
                                        <a rel="nofollow" href="{{Request::fullUrlWithQuery(['sale' => 'in_sale'])}}">Đang giảm giá</a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
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
                            <div class="filter-icon-mobile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders remove_filter"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                <span>Bộ lọc</span>
                            </div>
                        </div>
                        {{-- <div class="filter-icon-mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders remove_filter"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                            <span>Bộ lọc</span>
                        </div> --}}
                        <div class="sort">
                            <select name="" class="form-select rounded-0" id="sort">
                                <option value="{{Request::fullUrlWithQuery(['sort' =>'desc'])}}" {{Request::get('sort') == 'desc' ? 'selected' : ''}}>Sắp xếp theo thời gian mới nhất</option>
                                <option value="{{Request::fullUrlWithQuery(['sort' =>'asc'])}}" {{Request::get('sort') == 'asc' ? 'selected' : ''}}>Sắp xếp theo thời gian cũ nhất</option>
                                <option value="{{Request::fullUrlWithQuery(['sort' =>'price_asc'])}}" {{Request::get('sort') == 'price_asc' ? 'selected' : ''}}>Sắp xếp theo giá từ thấp đến cao</option>
                                <option value="{{Request::fullUrlWithQuery(['sort' =>'price_desc'])}}" {{Request::get('sort') == 'price_desc' ? 'selected' : ''}}>Sắp xếp theo giá từ cao đến thấp</option>
                            </select>
                        </div>
                    </div>
                    <div class="product-wrap grid">
                        @if (count($productByCate) > 0)
                            @foreach ($productByCate as $item)
                            <div class="product-item">
                                <div class="thumb-box">
                                    @if ($item->price_sale > 0)
                                        <div class="sale">-{{round(($item->price - $item->price_sale) / $item->price ,2)*100}}%</div>
                                    @endif
                                    
                                    <div class="image">
                                        <a href="{{route('home.product_single', $item->slug)}}">
                                        @if (!empty($item->more_image))
                                            @foreach (json_decode($item->more_image) as $image)
                                                @if ($loop->index == 0)
                                                    {{-- <span class="second-thumbnail" style="background-image: url({!!asset($image->image)!!})"></span> --}}
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
                                    <div class="category"><a href="#">{{$item->Category[0]->name}}</a></div>
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
                        @else
                            <span>Không có sản phẩm phù hợp</span>
                        @endif
                    </div>

                    <nav class="page-pagination">
                        {{ $productByCate->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </section>

</main>
@stop