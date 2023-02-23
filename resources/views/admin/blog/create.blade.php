@extends('admin.layouts.app')
@section('controller', 'Tin tức' )
@section('controller_route', route('blogs.index'))
@section('action', 'Thêm mới')
@section('content')
	<div class="container-fluid">
       	@include('flash::message')
       	<form action="{!! route('blogs.store') !!}" method="POST">
			@csrf
			<div class="row">
				<div class="col-12 col-sm-9">
					<div class="card card-dark card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Nội dung</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Nội dung SEO</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
                           
							<div class="tab-content" id="custom-tabs-three-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Tiêu đề *</label>
												<input type="text" class="form-control" name="title" value="{!! old('title') !!}">
											</div>
										</div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Danh mục</label>
                                                <select class="custom-select" name="category_id">
                                                    <option value="">Chọn</option>
                                                    @foreach($categories as $cate)
                                                        <option value="{{$cate->id}}" {{old('category_id') == $cate->id ? 'selected' : ''}}>{{ $cate->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

										<div class="col-sm-12">
											<div class="form-group">
												<label for="">Mô tả ngắn *</label>
												<textarea class="form-control" name="short_desc" cols="30" rows="3">{!! old('short_desc') !!}</textarea>
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<label for="">Nội dung *</label>
												<textarea class="content" name="content">{!! old('content') !!}</textarea>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
									<div class="form-group">
										<label>Meta Title</label>
										<label style="float: right;">Number of characters: <span id="countTitle">{{ @$data->meta_title != null ? mb_strlen( $data->meta_title, 'UTF-8') : 0 }}/120</span></label>
										<input type="text" class="form-control" name="meta_title" value="{!! old('meta_title', isset($data->meta_title) ? $data->meta_title : null) !!}" id="meta_title">
									</div>

									<div class="form-group">
										<label>Meta Description</label>
										<label style="float: right;">Number of characters: <span id="countMeta">{{ @$data->meta_description != null ? mb_strlen( $data->meta_description, 'UTF-8') : 0 }}/360</span></label>
										<textarea name="meta_description" class="form-control" id="meta_description" rows="3">{!! old('meta_description', isset($data->meta_description) ? $data->meta_description : null) !!}</textarea>
									</div>

									<div class="form-group">
										<label>Meta Keyword</label>
										<input type="text" class="form-control" name="meta_keyword" value="{!! old('meta_keyword', isset($data->meta_keyword) ? $data->meta_keyword : null) !!}">
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
							<h3 class="card-title">Đăng tin</h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" name="status" id="showCheckbox1" value="1" @if(old('status') == 1) checked="checked" @endif>
									<label for="showCheckbox1" class="custom-control-label">Hiển thị</label>
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
						<h3 class="card-title">Hình ảnh</h3>
						</div>
						<div class="card-body">
							<div class="" style="text-align: center;">
		                        <div class="image">
		                            <div class="image__thumbnail">
		                                <img src="{{ !empty(old('image')) ? old('image') : __NO_IMAGE_DEFAULT__ }}"
		                                     data-init="{{ __NO_IMAGE_DEFAULT__ }}">
		                                <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
		                                    <i class="fa fa-times"></i></a>
		                                <input type="hidden" value="{{ old('image') }}" name="image"/>
		                                <div class="image__button" onclick="fileSelect(this)">
		                                	<i class="fa fa-upload"></i>
		                                    Upload
		                                </div>
		                            </div>
		                        </div>
		                    </div>
						</div>
					</div>
					<div class="card card-secondary card-outline">
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
					</div>
				</div>
			</div>
		</form>
	</div>

@stop

@section('page_scripts')
	<script type="text/javascript">
		CKEDITOR.replace('content', {
			height: 500,
		})
		
		var baseUrl = window.location.protocol + '//' + window.location.host;
		var urlGetTag = '{!! route('blogs.getTags') !!}';
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
		console.log(urlGetTag);

	</script>
	
@endsection

