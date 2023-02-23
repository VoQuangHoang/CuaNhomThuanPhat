@extends('admin.layouts.app')
@section('controller', 'Cấu hình ViettelPost' )
@section('controller_route', route('admin.settings.viettel_post'))
@section('action', 'Cập nhật')
@section('content')
	<div class="container-fluid">
       	@include('flash::message')
       	<form action="{!! route('admin.settings.viettel_post.post') !!}" method="POST">
			@csrf
			<div class="row">
				<div class="col-12 col-sm-12">
					<div class="card card-dark card-tabs">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-three-info-all-tab" data-toggle="pill" href="#custom-tabs-three-info-all" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Đăng nhập</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-three-info-contact-tab" data-toggle="pill" href="#custom-tabs-three-info-contact" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Thông tin địa chỉ lấy hàng</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-three-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-three-info-all" role="tabpanel" aria-labelledby="custom-tabs-three-info-all-tab">
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="">Email/Số điện thoại Viettelpost</label>
												<input type="text" name="content[login_id]" class="form-control" value="{!! @$content->login_id !!}" required>
											</div>
										</div>
                                    </div>
                                    <div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label for="">Mật khẩu</label>
												<input type="password" name="content[password]" class="form-control" value="{!! @$content->password !!}" required>
											</div>
										</div>
			               			</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="text-danger">*Chú ý: Đăng nhập để cập nhật thông tin địa chỉ từ ViettelPost</label>
											</div>
										</div>
                                    </div>
                                    <div class="row">
										
                                        <div class="col-lg-12">
                                            <button class="btn btn-dark" type="submit">Đăng nhập</button>
                                        </div>
                                    </div>
								</div>
                                <div class="tab-pane fade" id="custom-tabs-three-info-contact" role="tabpanel" aria-labelledby="custom-tabs-three-info-contact-tab">
									<div class="row">
										<div class="col-sm-6">
											
											<div class="form-group">
												<label for="">Tên kho #{{$content->default_store}}</label>
												<input type="text" class="form-control" value="{{$store['name']}}" autocomplete="off" readonly="">
											</div>
									
											<div class="form-group">
												<label for="">Số điện thoại</label>
												<input type="text" class="form-control" value="{{$store['phone']}}" autocomplete="off" readonly="">
											</div>

											<div class="form-group">
												<label for="">Địa chỉ</label>
												<textarea class="form-control" rows="2" readonly>{{$store['address']}}</textarea>
											</div>

											<div class="radio">
												<div class="form-group">
													<label>
														<input type="radio" name="default_store" value="{{$content->default_store}}" class="default_store" checked> 
														Đặt làm mặc định
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card -->
					</div>
				</div>
			</div>
		</form>
	</div>

@stop

@section('scripts')
	<script>
		
	</script>
	
@endsection

@section('css')
	<link rel="stylesheet" href="{{ url('backend/plugins/datetimepicker/bootstrap-timepicker.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
@endsection

