@extends('frontend.layouts.master')
@section('content')
<main class="main">
    <section class="page-heading" style="background-image:url({{asset($contentPage->header->image)}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">{{$contentPage->header->h1}}</span>
            </div>
            <h1 class="page-title title-cate">{{$contentPage->header->h1}}</h1>
        </div>
    </section>
    <section class="hp-popular">
        <div class="container">
            <h2 class="section-title text-uppercase">{{$contentPage->cate->title}}</h2>
            <div class="hp-about-text text-center">
                {{$contentPage->cate->text}}
            </div>

            <div class="hp-popular-wrap d-flex flex-wrap">
                @foreach ($popularCate as $item)
                <div class="popular-item">
                    <a href="{{route('home.product_cate_single', $item->slug)}}">
                        <div class="popular-detail">
                            <h4 class="entry-category">{{$item->name}}</h4><span class="button-text">Shop Now</span>
                        </div>
                        <div class="popular-image">
                            <img src="{{asset($item->image)}}" alt="{{$item->name}}">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</main>
@stop
