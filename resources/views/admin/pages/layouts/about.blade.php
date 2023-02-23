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
                                        {{-- {{dd($contents)}} --}}
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối header</h5>
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="text-center">
                                                                <label>Hình ảnh nền khối</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail" style="height: 250px;">
                                                                        <img src="{{ @$contents->header->image ?  url('/').@$contents->header->image : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i></a>
                                                                            <input type="hidden" value="{{ @$contents->header->image }}" name="content[header][image]"/>
                                                                        <div class="image__button" onclick="fileSelect(this)"><i class="fa fa-upload"></i> Upload</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div>
                                                                <div class="form-group">
                                                                    <label for="">Text</label>
                                                                    <input class="form-control" type="text" name="content[header][text]" value="{{ @$contents->header->text }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Tiêu đề (h1)</label>
                                                                    <input class="form-control" type="text" name="content[header][title]" value="{{ @$contents->header->title }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối nội dung</h5>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <span><i class="fas fa-caret-square-right"></i> Trái</span>
                                                            <div class="mt-2">
                                                                <div class="form-group">
                                                                    <label for="">Tiêu đề</label>
                                                                    <input class="form-control" type="text" name="content[block][left][title1]" value="{{ @$contents->block->left->title1 }}">
                                                                </div>
                                                                <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[block][left][text1]" id="" rows="3">{!! @$contents->block->left->text1 !!}</textarea>
                                                                </div>
                                                                <hr class="mt-4">
                                                                <div class="form-group">
                                                                    <label for="">Tiêu đề</label>
                                                                    <input class="form-control" type="text" name="content[block][left][title2]" value="{{ @$contents->block->left->title2 }}">
                                                                </div>
                                                                <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[block][left][text2]" id="" rows="3">{!! @@$contents->block->left->text2 !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-12 offset-md-1">
                                                            <span><i class="fas fa-caret-square-right"></i> Phải</span>
                                                            <div class="mt-2">
                                                                <div class="form-group">
                                                                    <label for="">Tiêu đề (h2)</label>
                                                                    <input class="form-control" type="text" name="content[block][right][title3]" value="{{ @$contents->block->right->title3 }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Nội dung</label>
                                                                    <textarea class="form-control content" name="content[block][right][text3]" id="" rows="13">{!! @$contents->block->right->text3 !!}</textarea>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối nội dung và hình ảnh</h5>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div>
                                                                <label for="">Chi tiết</label>
                                                                <div class="repeater" id="repeater">
                                                                    <table class="table table-bordered page-table">
                                                                        <tbody class="step-group" id="sortable">
                                                                            @if(!empty(@$contents->about))
                                                                                @foreach (@$contents->about as $key => $value)
                                                                                    @include('admin.repeater.row-about')
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="text-right mb-2">
                                                                        <button class="btn btn-sm btn-info" 
                                                                            onclick="repeater(event,this,'{{ route('get.layout') }}','.index', 'about', '.about')">
                                                                            <i class="fas fa-plus-circle"></i> Thêm nội dung
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
                                                    <h5 class="title-kh">Khối nội dung</h5>
                                                    <div class="row align-items-center mt-2">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Nội dung</label>
                                                                <textarea class="form-control" name="content[block1][text]" id="" rows="2">{!! @$contents->block1->text !!}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Nguồn</label>
                                                                <input class="form-control" type="text" name="content[block1][author]" value="{{ @$contents->block1->author }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối hình ảnh</h5>
                                                    <div class="row align-items-center mt-2">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="text-center">
                                                                <label>Hình ảnh</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail" style="height: 200px;">
                                                                        <img src="{{ @$contents->block2->image1 ?  url('/').@$contents->block2->image1 : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i></a>
                                                                            <input type="hidden" value="{{ @$contents->block2->image1 }}" name="content[block2][image1]"/>
                                                                        <div class="image__button" onclick="fileSelect(this)"><i class="fa fa-upload"></i> Upload</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">Link</label>
                                                                <input class="form-control" type="text" name="content[block2][link1]" value="{{ @$contents->block2->link1 }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="text-center">
                                                                <label>Hình ảnh</label>
                                                                <div class="image text-center">
                                                                    <div class="image__thumbnail" style="height: 200px;">
                                                                        <img src="{{ @$contents->block2->image2 ?  url('/').@$contents->block2->image2 : __NO_IMAGE_DEFAULT__ }}"
                                                                            data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                        <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                                                            <i class="fa fa-times"></i></a>
                                                                            <input type="hidden" value="{{ @$contents->block2->image2 }}" name="content[block2][image2]"/>
                                                                        <div class="image__button" onclick="fileSelect(this)"><i class="fa fa-upload"></i> Upload</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                      
                                                            <div class="form-group">
                                                                <label for="">Link</label>
                                                                <input class="form-control" type="text" name="content[block2][link2]" value="{{ @$contents->block2->link2 }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- {{dd($contents)}} --}}
                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối nội dung</h5>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <label for=""><i class="fas fa-caret-square-right"></i> Nội dung theo bước</label>
                                                            <div class="repeater" id="repeater">
                                                                <table class="table table-bordered page-table">
                                                                    <tbody class="step-group" id="sortable">
                                                                        @if(!empty(@$contents->about2))
                                                                            @foreach (@$contents->about2 as $key => $value)
                                                                                @include('admin.repeater.row-about2')
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                                <div class="text-right mb-2">
                                                                    <button class="btn btn-sm btn-info" 
                                                                        onclick="repeater(event,this,'{{ route('get.layout') }}','.index', 'about2', '.about2')">
                                                                        <i class="fas fa-plus-circle"></i> Thêm nội dung (bước)
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="mt-2">
                                                                <label for=""><i class="fas fa-caret-square-right"></i> Nội dung đơn</label>
                                                                <div class="form-group">
                                                                  <textarea class="form-control content" name="content[about3][text]">{!! @$contents->about3->text !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h5 class="title-kh">Khối review</h5>
                                                    <div class="row align-items-center mt-2">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Tiêu đề</label>
                                                                <input class="form-control" type="text" name="content[review][title]" value="{{ @$contents->review->title }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Mô tả ngắn</label>
                                                                <textarea class="form-control" name="content[review][text]" id="" rows="3">{!! @$contents->review->text !!}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <label for=""><i class="fas fa-caret-square-right"></i> Reviews</label>
                                                            <div class="repeater" id="repeater">
                                                                <table class="table table-bordered page-table">
                                                                    <tbody class="step-group" id="sortable">
                                                                        @if(!empty(@$contents->review->list))
                                                                            @foreach (@$contents->review->list as $key => $value)
                                                                                @include('admin.repeater.row-review')
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                                <div class="text-right mb-2">
                                                                    <button class="btn btn-sm btn-info" 
                                                                        onclick="repeater(event,this,'{{ route('get.layout') }}','.index', 'review', '.review')">
                                                                        <i class="fas fa-plus-circle"></i> Thêm đánh giá
                                                                    </button>
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