@extends('frontend.layouts.master')
@section('content')
<main class="site-main news-detail">
    <div class="container">
        <div class="page-breadcrumb">
            <a href="{{ route('home.index') }}">Trang chủ</a>
            <span class="divide">/</span>
            <a href="{{ route('home.spa') }}">Spa</a>
            <span class="divide">/</span>
            <span class="last">{{$spa->title}} </span>
        </div>

        <div class="entry-heading">
            <h1>{{$spa->title}}</h1>
            <div class="date">Ngày đăng: {{date_format($spa->created_at, 'd/m/Y')}}</div>
        </div>

        <div class="entry-content">
            {!! $spa->content !!}
        </div>
    </div>
</main>
@endsection