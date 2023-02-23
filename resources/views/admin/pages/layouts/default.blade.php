@extends('admin.layouts.app')
@section('controller', 'Pages')
@section('controller_route', route('pages.list') )
@section('action','List')
@section('content')
<div class="container-fluid">
    <div class="card card-dark card-outline">
        <div class="card-body">
            @include('flash::message')
            <form action="{{ route('pages.build.post') }}" method="POST">
                @csrf
                <input name="type" value="{{ $data->type }}" type="hidden">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-info">
                            <h5>{{ $data->name_page }}</h5>
                            @if (\Route::has($data->route))
                                <a href="{{ route($data->route) }}" target="_blank">
                                    <i class="far fa-hand-point-right" aria-hidden="true"></i>
                                     {{ route($data->route) }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="setting-tab" data-toggle="pill" href="#setting" role="tab"
                            aria-controls="setting" aria-selected="true">Nội dung trang</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link active" id="seo-tab" data-toggle="pill" href="#seo" role="tab"
                            aria-controls="seo" aria-selected="false">Nội dung SEO</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="row mt-4 align-items-center">
                            <div class="col-sm-3">
                                <div class="form-group text-center">
                                    <label>Image</label>
                                    <div class="image text-center">
                                        <div class="image__thumbnail">
                                            <img src="{{ $data->image ?  url('/').$data->image : __NO_IMAGE_DEFAULT__ }}"
                                                data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                            <a href="javascript:void(0)" class="image__delete"
                                                onclick="urlFileDelete(this)">
                                                <i class="fa fa-times"></i></a>
                                            <input type="hidden" value="{{ @$data->image }}" name="image" />
                                            <div class="image__button" onclick="fileSelect(this)"><i
                                                    class="fa fa-upload"></i> Upload</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="{{ @$data->meta_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="meta_description" class="form-control"
                                        rows="5">{!! @$data->meta_description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Keyword</label>
                                    <input type="text" name="meta_keyword" class="form-control"
                                        value="{!! @$data->meta_keyword !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                        ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                        Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                        ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc
                        euismod pellentesque diam.
                    </div> -->
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                </div>    
            </form>
        </div>
    </div>
</div>
@stop
