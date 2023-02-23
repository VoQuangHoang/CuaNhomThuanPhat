@extends('admin.layouts.app')
@section('controller', 'Sản phẩm' )
@section('controller_route', route('products.index'))
@section('action', 'Thêm mới')
@section('content')
<div class="container-fluid">
    @include('flash::message')
    <form action="{!! route('products.store') !!}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="card card-dark card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                    href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                    aria-selected="true">Nội dung</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-image-tab" data-toggle="pill"
                                    href="#custom-tabs-image" role="tab" aria-controls="custom-tabs-image"
                                    aria-selected="false">Thư viện ảnh</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-three-profile" role="tab"
                                    aria-controls="custom-tabs-three-profile" aria-selected="false">Nội dung SEO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                aria-labelledby="custom-tabs-three-home-tab">
                                <div class="form-group">
                                    <label>Tên sản phẩm *</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{!! old('name') !!}">
                                </div>

                                <div class="form-group">
                                    <label>Đường dẫn tĩnh * <small>(tự động theo tên sản phẩm)</small></label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        value="{!! old('slug') !!}">
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Mô tả ngắn</label>
                                            <textarea class="content"
                                                name="short_desc">{!! old('short_desc', @$data->short_desc) !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Mô tả chi tiết</label>
                                            <textarea class="content"
                                                name="description">{!! old('description', @$data->description) !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-image" role="tabpanel"
                                aria-labelledby="custom-tabs-image-tab">
                                <div class="repeater" id="repeater">
                                    <table class="table table-bordered page-table">
                                        @if(old('list'))
                                        <?php $contents = json_decode(json_encode(old('list'))); ?>
                                        @endif
                                        <thead>
                                            <tr>
                                                <th>Hình ảnh</th>
                                                <th>Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable">
                                            @if(@$contents)
                                                @foreach ($contents as $key => $value)
                                                    @include('admin.repeater.row-image')
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="text-right" style="margin-bottom: 30px">
                                        <button class="btn btn-sm btn-info"
                                            onclick="repeater(event,this,'{{ route('get.layout') }}','.index', 'image', '.image')">Thêm
                                            ảnh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                aria-labelledby="custom-tabs-three-profile-tab">
                                <div class="form-group">
                                    <label>Thẻ meta title:</label>
                                    <label style="float: right;">Số ký tự đã dùng: <span
                                            id="countTitle">{{ @$data->meta_title != null ? mb_strlen( $data->meta_title, 'UTF-8') : 0 }}/70</span></label>
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{!! old('meta_title', isset($data->meta_title) ? $data->meta_title : null) !!}"
                                        id="meta_title">
                                </div>

                                <div class="form-group">
                                    <label>Thẻ meta description:</label>
                                    <label style="float: right;">Số ký tự đã dùng: <span
                                            id="countMeta">{{ @$data->meta_description != null ? mb_strlen( $data->meta_description, 'UTF-8') : 0 }}/360</span></label>
                                    <textarea name="meta_description" class="form-control" id="meta_description"
                                        rows="3">{!! old('meta_description', isset($data->meta_description) ? $data->meta_description : null) !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Thẻ meta keyword:</label>
                                    <input type="text" class="form-control" name="meta_keyword"
                                        value="{!! old('meta_keyword', isset($data->meta_keyword) ? $data->meta_keyword : null) !!}">
                                </div>
                            </div>

                    

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Đăng sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <select class="form-control" name="status" id="status">
                            <option value="1" {{old('status') == 1 ? 'selected' : ''}}>Công khai</option>
                            <option value="2" {{old('status') == 2 ? 'selected' : ''}}>Chờ duyệt</option>
                            <option value="3" {{old('status') == 3 ? 'selected' : ''}}>Thùng rác</option>
                            </select>
                        </div>
                        <hr>
                        <label for="">Đặc điểm</label>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="popular" id="catePopular"
                                    value="1" {{old('popular') == 1 ? 'checked' : ''}}>
                                <label for="catePopular" class="custom-control-label">Sản phẩm nổi bật</label>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <label><em><span class="text-red">Lưu ý:</span> * trường bắt buộc nhập.</em></label>
                    </div>
                </div>
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục sản phẩm *</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="overflow:auto; max-height:600px">
                            <?php menuMultiPost($categories,0,$str='',old('category')); ?>
                        </div>
                    </div>
                </div>
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh đại diện *</h3>
                    </div>
                    <div class="card-body">
                        <div class="" style="text-align: center;">
                            <div class="image">
                                <div class="image__thumbnail">
                                    <img src="{{ !empty(old('image', @$data->image)) ? old('image', @$data->image) : __NO_IMAGE_DEFAULT__ }}"
                                        data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                    <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
                                        <i class="fa fa-times"></i></a>
                                    <input type="hidden" value="{{ old('image', @$data->image) }}" name="image" />
                                    <div class="image__button" onclick="fileSelect(this)">
                                        <i class="fa fa-upload"></i>
                                        Upload
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card card-secondary card-outline">
                    <div class="card-header">
                    <h3 class="card-title">Thẻ <small>(tag - nhập để tìm kiếm thẻ hoặc thêm mới)</small></h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-5">
                            <select name="tags[]" id="tag" class="form-control select2" multiple="multiple">
                                @if (old('tags'))
                                    @foreach(old('tags') as $tag)
                                        <option value="{{ $tag }}" selected="selected">{{ $tag }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </form>
</div>

@stop

@section('page_scripts')
    {{-- <script>

        CKEDITOR.replace('description', {
            height: 500,
        });

        function checkAttributes(code){
            console.log('#'+code);
            const checked = $('#'+code).is(':checked')
            console.log(checked);
            if (checked) {
                $('#box-'+code).show();
            } else {
                $('#box-'+code).hide();
            }
        }
        
        function newSku(code){
            var new_sku = '{{ generateRandomCode(12) }}';
            $('input[name="sku"]').val(new_sku);
        }

        var baseUrl = window.location.protocol + '//' + window.location.host;
		var urlGetTag = '{!! route('products.getTags') !!}';
		$('#tag').select2({
			multiple: true,
			tags: true,
			tokenSeparators: [','],
			language: "vi",
			ajax: {
				url: urlGetTag,
				dataType: 'json',
				data: function (params) {
					return {
						q: $.trim(params.term)
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			},
		})
    </script> --}}
@endsection