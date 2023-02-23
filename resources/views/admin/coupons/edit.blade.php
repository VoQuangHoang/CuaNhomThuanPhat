@extends('admin.layouts.app')
@section('controller', 'Mã khuyến mãi' )
@section('controller_route', route('coupons.index'))
@section('action', 'Cập nhật')
@section('content')
	<div class="container-fluid">
       	@include('flash::message')
       	<form action="{{ route('coupons.update', $data->id) }}" method="POST">
			@csrf
			@method('put')
			<div class="row">
				<div class="col-12 col-sm-9">
					<div class="card card-dark card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-brands-tab" data-toggle="pill" href="#custom-tabs-brands" role="tab" aria-controls="custom-tabs-brands" aria-selected="true">Nội dung</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-three-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-brands" role="tabpanel" aria-labelledby="custom-tabs-brands-tab">
								
									<div class="form-group">
										<label>Mã code <small>(tự động hoặc tùy biến)</small></label>
										<input type="text" class="form-control" name="code" value="{!! old('code', $data->code) !!}">
									</div>

									<div class="form-group">
										<label>Tiêu đề mã giảm giá</label>
										<input type="text" class="form-control" name="name" value="{!! old('name', $data->name) !!}">
									</div>

									<div class="form-group">
									  <label for="">Loại</label>
									  <select class="form-control" name="type">
										<option value="1" {{old('type', $data->type) == 1 ? 'selected' : ''}}>Giảm theo %</option>
										<option value="2" {{old('type', $data->type) == 2 ? 'selected' : ''}}>Giảm theo giá tiền</option>
									  </select>
									</div>

									<div class="form-group">
										<label>Giá trị giảm <small>(phụ thuộc loại)</small></label>
										<input type="number" min="1" class="form-control" name="value" value="{{ old('value',$data->value) }}">
									</div>

									<div class="form-group">
										<label>Điều kiện áp dụng <small>(Tổng giá trị đơn hàng lớn hơn hoặc bằng - Bỏ trống nếu không có điều kiện)</small></label>
										<input type="text" class="form-control" name="condition" value="{!! old('condition', $data->condition) !!}">
									</div>

                                    <div class="form-group">
										<label>Mô tả</label>
										<textarea class="form-control" name="desc" id="" cols="30" rows="4">{!! old('desc', $data->desc) !!}</textarea>
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
							<h3 class="card-title">Đăng mã</h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" name="status" id="showCheckbox1"
										value="1" {{old('status', $data->status) == 1 ? 'checked' : ''}}>
									<label for="showCheckbox1" class="custom-control-label">Cho phép áp dụng</label>
								</div>
							</div>
		                    <div class="text-right">
		                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
		                    </div>
						</div>
					</div>
				</div>	
			</div>
		</form>
	</div>

@stop