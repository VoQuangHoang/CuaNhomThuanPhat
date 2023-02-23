@extends('admin.layouts.app')
@section('controller', 'Thương hiệu' )
@section('controller_route', route('brands.index'))
@section('action', 'Cập nhật')
@section('content')
	<div class="container-fluid">
       	@include('flash::message')
       	<form action="{!! route('brands.update', @$data->id) !!}" method="POST">
			@csrf
            @method('PUT')
			<div class="row">
				<div class="col-12 col-sm-9">
					<div class="card card-secondary card-outline card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-brands-tab" data-toggle="pill" href="#custom-tabs-brands" role="tab" aria-controls="custom-tabs-brands" aria-selected="true">Chi tiết tin tức</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-three-brands-seo-tab" data-toggle="pill" href="#custom-tabs-three-brands-seo" role="tab" aria-controls="custom-tabs-three-brands-seo" aria-selected="false">Cấu hình SEO</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-three-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-brands" role="tabpanel" aria-labelledby="custom-tabs-brands-tab">
								
									<div class="form-group">
										<label>Tên thương hiệu</label>
										<input type="text" class="form-control" name="name" id="name" value="{!! old('name', @$data->name) !!}">
									</div>

                                    <div class="form-group">
										<label>Mô tả ngắn</label>
										<textarea class="form-control" name="description" id="" cols="30" rows="5">{!! old('description', @$data->description) !!}</textarea>
									</div>
									
								</div>
								<div class="tab-pane fade" id="custom-tabs-three-brands-seo" role="tabpanel" aria-labelledby="custom-tabs-three-brands-seo-tab">
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
							<h3 class="card-title">Cập nhật thương hiệu</h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" name="status" id="showCheckbox1"
										value="1" {{ old('status',@$data->status) == 1 ? 'checked' : null }}>
									<label for="showCheckbox1" class="custom-control-label">Hiển thị</label>
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
										<img src="{{ !empty(@$data->image) ? @$data->image : __NO_IMAGE_DEFAULT__ }}"
												data-init="{{ __NO_IMAGE_DEFAULT__ }}">
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
		</form>
	</div>

@stop