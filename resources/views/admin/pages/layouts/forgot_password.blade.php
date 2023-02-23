@extends('admin.layouts.app')
@section('controller', 'Trang đơn')
@section('controller_route', route('pages.list') )
@section('action','Cập nhật')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
            <form action="{{ route('pages.build.post') }}" method="POST">
                @csrf
                <input name="type" value="{{ $data->type }}" type="hidden">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-info">
                            <h5>{{ $data->name_page }}</h5>
                            @if(\Route::has($data->route))
                                <a href="{{ route($data->route) }}" target="_blank">
                                    <i class="far fa-hand-point-right" aria-hidden="true"></i>
                                    {{ route($data->route) }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="setting-tab" data-toggle="pill" href="#setting" role="tab"
                            aria-controls="setting" aria-selected="true">Nội dung trang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="seo-tab" data-toggle="pill" href="#seo" role="tab" aria-controls="seo"
                            aria-selected="false">Nội dung SEO</a>
                    </li>
                </ul>

                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped page-table">
                                        <?php 
                                            if(!empty($data->content)){
                                                $contents = json_decode($data->content);
                                            } 
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối header</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="text-center">
                                                                <label>Hình ảnh nền khối</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail" style="height: 200px">
                                                                        <img src="{{ @$contents->header->image ?  url('/').@$contents->header->image : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                        <input type="hidden" value="{{ @$contents->header->image }}" name="content[header][image]" />
                                                                        <div class="image__button" onclick="fileSelect(this)">
                                                                            <i class="fa fa-upload"></i> Upload
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 offset-md-1 col-sm-12">
                                                            <div>
                                                                <div class="form-group">
                                                                    <label for="">Tiêu đề (h1)</label>
                                                                    <input class="form-control" type="text" name="content[header][h1]" value="{{ @$contents->header->h1 }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab seo -->
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="row mt-4 align-items-center">
                            <div class="col-sm-2">
                                <div class="form-group text-center">
                                    <label>Image</label>
                                    <div class="image text-center">
                                        <div class="image__thumbnail">
                                            <img src="{{ old('image', @$data->image) ?  url('/').old('image', @$data->image) : __NO_IMAGE_DEFAULT__ }}"
                                                data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                            <a href="javascript:void(0)" class="image__delete"
                                                onclick="urlFileDelete(this)">
                                                <i class="fa fa-times"></i></a>
                                            <input type="hidden"
                                                value="{{ old('image', @$data->image) }}"
                                                name="image" />
                                            <div class="image__button" onclick="fileSelect(this)"><i
                                                    class="fa fa-upload"></i> Upload</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label for="">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="{{ old('meta_title', @$data->meta_title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Description</label>
                                    <textarea name="meta_description" class="form-control"
                                        rows="5">{!! old('meta_description', @$data->meta_description) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Keyword</label>
                                    <input type="text" name="meta_keyword" class="form-control"
                                        value="{!! old('meta_keyword', @$data->meta_keyword) !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
            </form>
        </div>
    </div>
</div>
@stop
