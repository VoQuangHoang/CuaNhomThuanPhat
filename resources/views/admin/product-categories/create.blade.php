@extends('admin.layouts.app')
@section('controller', 'Danh mục sản phẩm' )
@section('controller_route', route('product-categories.index'))
@section('action', 'Thêm mới')
@section('content')
	<div class="container-fluid">
       	@include('flash::message')
       	<form action="{{ route('product-categories.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-12 col-sm-9">
					<div class="card card-secondary card-outline card-tabs">
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
								
									<div class="form-group">
										<label>Tên danh mục</label>
										<input type="text" class="form-control" name="name" id="name" value="{!! old('name') !!}">
									</div>

									<div class="form-group">
										<label>Đường dẫn</label>
										<input type="text" class="form-control" name="slug" id="slug" value="{!! old('slug') !!}">
									</div>
								
									<div class="form-group">
										<label>Danh mục cha</label>
										<select class="custom-select" name="parent_id">
											<option value="0">Danh mục cha</option>
											@php menuMulti($categories, 0, '', old('parent_id', 0)) @endphp
										</select>
									</div>
									<div class="form-group">
										<label for="">Mô tả danh mục</label>
										<textarea class="form-control content" name="description">{!! old('description') !!}</textarea>
									</div>
									
								</div>
								<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
									<div class="form-group">
										<label>Meta Title</label>
										<label style="float: right;">Số ký tự đã dùng: <span id="countTitle">{{ @$data->meta_title != null ? mb_strlen( $data->meta_title, 'UTF-8') : 0 }}/70</span></label>
										<input type="text" class="form-control" name="meta_title" value="{!! old('meta_title', isset($data->meta_title) ? $data->meta_title : null) !!}" id="meta_title">
									</div>

									<div class="form-group">
										<label>Meta Description</label>
										<label style="float: right;">Số ký tự đã dùng: <span id="countMeta">{{ @$data->meta_description != null ? mb_strlen( $data->meta_description, 'UTF-8') : 0 }}/360</span></label>
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
							<h3 class="card-title">Đăng danh mục</h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" name="active" id="cateActive"
										value="1" {{old('active') == 1 ? 'checked' : ''}}>
									<label for="cateActive" class="custom-control-label">Hiển thị</label>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" name="popular" id="catePopular"
										value="1" {{old('popular') == 1 ? 'checked' : ''}}>
									<label for="catePopular" class="custom-control-label">Danh mục nổi bật <small>(hiển thị trang chủ)</small></label>
								</div>
							</div>
		                    <div class="text-right">
		                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
		                    </div>
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
		                                <img src="{{ !empty(old('image', @$data->image)) ? old('image', @$data->image) : __NO_IMAGE_DEFAULT__ }}"
		                                     data-init="{{ __IMAGE_DEFAULT__ }}">
		                                <a href="javascript:void(0)" class="image__delete" onclick="urlFileDelete(this)">
		                                    <i class="fa fa-times"></i></a>
		                                <input type="hidden" value="{{ old('image', @$data->image) }}" name="image"/>
		                                <div class="image__button" onclick="fileSelect(this)">
		                                	<i class="fa fa-upload"></i>
		                                    Upload
		                                </div>
		                            </div>
		                        </div>
		                    </div>
						</div>
					</div>
				</div>	
			</div>
		</form>
	</div>

@stop

@section('page_scripts')
	<script>
		CKEDITOR.replace('description', {
			height: 400,
		})
	</script>
	
@endsection