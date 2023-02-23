@extends('frontend.layouts.master')
@section('content')
<main class="site-main">
    <section class="page-heading" style="background-image:url({{asset($contentPage->header->image)}});">
        <div class="container">
            <div class="page-breadcrumb">
                <a href="{{route('home.index')}}">Trang chủ</a>
                <span class="divide">/</span>
                <span class="last">{{$contentPage->header->h1}}</span>
            </div>
            <h1 class="page-title">{{$contentPage->header->h1}}</h1>
        </div>
    </section>
    <div class="news-detail">
    <div class="container">

        <div class="entry-content mt-3">
            {!! $contentPage->content !!}
        </div>

    </div>
    </div>
</main>
@endsection