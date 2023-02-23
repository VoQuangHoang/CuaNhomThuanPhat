@extends('admin.layouts.app')
@section('controller','Tài khoản')
@section('controller_route', route('users.index'))
@section('action','Chỉnh sửa')
@section('content')
	<!-- Main content -->
<div class="container-fluid">

@include('flash::message')
<form action="{{ route('users.update', $data->id) }}" method="POST" autocomplete="off">
	@csrf
	@method('put')
	<div class="row">
		<div class="col-12 col-sm-9">
			<div class="card card-secondary card-outline">
				<div class="card-body">
					<div class="form-group">
						<label>Họ và tên</label>
						<input type="text" class="form-control" name="name" value="{!! old('name', $data->name) !!}">
					</div>

					<div class="form-group">
						<label>Số điện thoại</label>
						<input type="text" class="form-control" name="phone" value="{!! old('phone', $data->phone) !!}">
					</div>
					
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email" value="{!! old('email', $data->email) !!}">
					</div>

					{{-- @role('Quản trị viên') --}}
					<div class="form-group">
						<label>Vai trò</label>
						<select name="role_id" class="form-control" required>
								<option value="" selected disabled>Chọn</option>
							@foreach($roles as $key => $role)
								<option value="{{$role->id}}" {{ old('role_id',@$userData['role']) == $role->id ? 'selected' : null }}>{{$role->name}}</option>
							@endforeach
						</select>
					</div>
					{{-- @endrole --}}

					<div>
						<a class="btn btn-sm btn-info mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
						Đổi mật khẩu
						</a>
						{{-- {{dd($errors)}} --}}
					</div>
					<div class="collapse" id="collapseExample">
						<div class="">
							<div class="form-group">
								<label>Mật khẩu</label>
								<input type="password" class="form-control" name="password" value="">
							</div>
							<div class="form-group">
								<label>Nhập lại mật khẩu</label>
								<input type="password" class="form-control" name="repassword" value="">
							</div>
						</div>
					</div>
				
				</div>
				
				
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="card card-secondary card-outline">
				<div class="card-header">
					<h3 class="card-title">Cập nhật tài khoản</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" type="checkbox" name="active" id="showCheckboxActive" value="1" @if($data->active ==1) checked @endif>
							<label for="showCheckboxActive" class="custom-control-label">Kích hoạt</label>
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
								<img src="{{ old('image',$data->image) ? old('image',$data->image) :  __NO_IMAGE_DEFAULT__ }}"
									data-init="{{ __NO_IMAGE_DEFAULT__ }}">
								<a href="javascript:void(0)" class="image__delete"
									onclick="urlFileDelete(this)">
									<i class="fa fa-times"></i></a>
								<input type="hidden" value="{{ old('image',$data->image) }}" name="image" />
								<div class="image__button" onclick="fileSelect(this)"><i
										class="fa fa-upload"></i> Upload</div>
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
	@if($errors->has('repassword'))
		<script>
			jQuery(document).ready(function($) {
				$('#collapseExample').collapse({
					toggle: true,
				});
			});
		</script>
	@endif
@endsection