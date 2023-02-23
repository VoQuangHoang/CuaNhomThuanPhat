@extends('frontend.layouts.master')
@section('content')
<main class="site-main product-listing">
    <section class="page-heading" style="background-color: #f9f3f2;">
        <div class="container">
            {{-- <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">Tin tức</span>
            </div> --}}
            <h1 class="page-title title-cate">Spa : {{$cate->name}}</h1>
        </div>
    </section>

    <section class="product-listing-container">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-3">
                    <div class="product-filter">
                        <h3 class="filter-title text-uppercase">Mạng xã hội</h3>
                        <div class="news-social-listing">
                            
                            <a href="{{ !empty($site_info->social->facebook) ? $site_info->social->facebook : 'https://www.facebook.com/'}}" target="_blank" class="facebook">
                                <span class="social-icon"><i class="fab fa-facebook-f"></i></span>
                                <span class="social-text">facebook</span>
                                <span class="social-label">Follow</span>
                            </a>
                            <a href="{{!empty($site_info->social->instagram) ? $site_info->social->instagram : 'https://www.instagram.com/'}}" target="_blank" class="instagram">
                                <span class="social-icon"><i class="fab fa-instagram"></i></span>
                                <span class="social-text">instagram</span>
                                <span class="social-label">Follow</span>
                            </a>
                            <a href="{{!empty($site_info->social->twitter) ? $site_info->social->twitter : 'https://twitter.com/'}}" target="_blank" class="twitter">
                                <span class="social-icon"><i class="fab fa-twitter"></i></span>
                                <span class="social-text">twitter</span>
                                <span class="social-label">Follow</span>
                            </a>
                            <a href="{{!empty($site_info->social->youtube) ? $site_info->social->youtube : 'https://www.youtube.com/'}}" target="_blank" class="pinterest">
                                <span class="social-icon"><i class="fab fa-youtube"></i></span>
                                <span class="social-text">youtube</span>
                                <span class="social-label">Follow</span>
                            </a>
                        </div>
                        <h3 class="filter-title text-uppercase">Danh mục SPA</h3>
                        <div class="filter-check">
                            <ul class="filter-check-nav-list">
                                @foreach ($cateSpa as $item)
                                <li class="filter-check-nav-list-item {{\Request('slug') == $item->slug ? 'active' : ''}}">
                                    <div class="type-button">
                                        <span class="button-box"></span>
                                        <a rel="nofollow" href="{{route('home.spa.single', $item->slug)}}">{{$item->name}}</a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <h3 class="filter-title text-uppercase">Dịch vụ spa phổ biến</h3>
                        <div class="news-sidebar mt-3 mb-4">
                            @foreach ($mostViewSpa as $item)
                                <a href="{{ route('home.spa.single', $item->slug) }}" class="news-item">
                                    <img src="{{asset($item->image)}}" alt="news">
                                    <span class="title limit-text-3">
                                        {{$item->title}}
                                    </span>
                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="col-lg-9">
                    @if (count($cateBySlug) > 0)
                    <div class="news-listing">
                        @foreach ($cateBySlug as $item)
                        <div class="news-item">
                            <div class="thumbnail">
                                <a href="{{ route('home.spa.single', $item->slug) }}">
                                    <img src="{{asset($item->image)}}" alt="{{$item->name}}">
                                </a>
                            </div>
                            <div class="content">
                                <div class="d-flex">
                                    <div class="title-cate">
                                        <a href="">{{$item->Category->name}}</a>
                                    </div>
                                    
                                </div>
                                <h4 class="title">
                                    <a href="{{ route('home.spa.single', $item->slug) }}">{{$item->title}}</a>
                                </h4>
                                <p class="desc limit-text-2">
                                    {{$item->short_desc}}
                                </p>
                                <div class="metadata">
                                    <div class="date">{{date_format($item->created_at, 'd/m/Y')}}</div>
                                    <div class="action">
                                        <a href="{{ route('home.spa.single', $item->slug) }}">Đọc tiếp</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <nav class="page-pagination">
                        {{ $cateBySlug->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                    @else
                    <span>Chưa có dịch vụ phù hợp</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

</main>
@endsection