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
                    <li class="nav-item">
                        <a class="nav-link active" id="setting-tab" data-toggle="pill" href="#setting" role="tab"
                            aria-controls="setting" aria-selected="true">Nội dung trang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="seo-tab" data-toggle="pill" href="#seo" role="tab"
                            aria-controls="seo" aria-selected="false">Nội dung SEO</a>
                    </li>
                </ul>

                <div class="tab-content" id="custom-tabs-three-tabContent">

                    <!-- Tab content -->
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
                                                    <h5 class="title-kh">Khối slider ảnh</h5>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div>
                                                                <label for="">Slider</label>
                                                                <div class="repeater" id="repeater">
                                                                    <table class="table table-bordered page-table">
                                                                        <tbody class="step-group" id="sortable">
                                                                           
                                                                            @if(!empty(@$contents->slider))
                                                                            
                                                                                @foreach (@$contents->slider as $key => $value)
                                                                                    @include('admin.repeater.row-slider')
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right mb-2">
                                                                        <button class="btn btn-sm btn-info" 
                                                                            onclick="repeater(event,this,'{{ route('get.layout') }}','.index', 'slider', '.slider')">
                                                                            <i class="fas fa-plus-circle"></i> Thêm slider
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối giới thiệu</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                              <label for="">Tiêu đề</label>
                                                              <input type="text" class="form-control" name="content[introduce][title]" value="{!! @$contents->introduce->title !!}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[introduce][text]" id="" rows="2">{!! @$contents->introduce->text !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối banner</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                                            <div class="text-center">
                                                                <label>Hình ảnh</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail">
                                                                        <img src="{{ @$contents->banner1->image ?  url('/').@$contents->banner1->image : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i></a>
                                                                            <input type="hidden" value="{{ @$contents->banner1->image }}" name="content[banner1][image]"/>
                                                                        <div class="image__button" onclick="fileSelect(this)"><i class="fa fa-upload"></i> Upload</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-9">
                                                            <div class="form-group">
                                                                <label for="">Tiêu đề</label>
                                                                <input class="form-control" type="text" name="content[banner1][text1]" value="{{ @$contents->banner1->text1 }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <input class="form-control" type="text" name="content[banner1][text2]" value="{{ @$contents->banner1->text2 }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Link</label>
                                                                <input class="form-control" type="text" name="content[banner1][link]" value="{{ @$contents->banner1->link }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                                            <div class="text-center">
                                                                <label>Hình ảnh</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail">
                                                                        <img src="{{ @$contents->banner2->image ?  url('/').@$contents->banner2->image : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i></a>
                                                                            <input type="hidden" value="{{ @$contents->banner2->image }}" name="content[banner2][image]"/>
                                                                        <div class="image__button" onclick="fileSelect(this)"><i class="fa fa-upload"></i> Upload</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Tiêu đề</label>
                                                                <input class="form-control" type="text" name="content[banner2][text1]" value="{{ @$contents->banner2->text1 }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <input class="form-control" type="text" name="content[banner2][text2]" value="{{ @$contents->banner2->text2 }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Link</label>
                                                                <input class="form-control" type="text" name="content[banner2][link]" value="{{ @$contents->banner2->link }}">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối thời gian khuyến mãi</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="content" name="content[sale][text]" id="" rows="2">{!! @$contents->sale->text !!}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label for="">Thời gian đếm ngược</label>
                                                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                                                    <input type="text" name="content[sale][time]" value="{{ @$contents->sale->time }}" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                                                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối tin tức</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                              <label for="">Tiêu đề</label>
                                                              <input type="text" class="form-control" name="content[blog][title]" value="{!! @$contents->blog->title !!}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[blog][text]" id="" rows="2">{!! @$contents->blog->text !!}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Link</label>
                                                                <textarea class="form-control" name="content[blog][link]" id="" rows="2">{!! @$contents->blog->link !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối danh mục phổ biến</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                              <label for="">Tiêu đề</label>
                                                              <input type="text" class="form-control" name="content[cate][title]" value="{!! @$contents->cate->title !!}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[cate][text]" id="" rows="2">{!! @$contents->cate->text !!}</textarea>
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
                                            <input type="hidden" value="{{ old('image', @$data->image) }}" name="image" />
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
@section('page_scripts')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker4').datetimepicker({
            format: 'YYYY/MM/DD'
        });
    });
</script>
@endsection