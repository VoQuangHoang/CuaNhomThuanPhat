@extends('admin.layouts.app')
@section('controller','Tài khoản quản trị')
@section('controller_route', route('users.index'))
@section('action','Thêm')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" class="form-control" name="name" value="{!! old('name') !!}">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{!! old('phone') !!}">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" name="repassword" value="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{!! old('email') !!}">
                        </div>
                        <div class="form-group">
                            <label>Vai trò</label>
                            <select name="role_id" class="form-control">
                                <option value="" selected disabled>Chọn</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    </div>
                </div>
            </div>
			<div class="col-12 col-sm-3">
				<div class="card card-secondary card-outline">
					<div class="card-header">
						<h3 class="card-title">Thêm quản trị</h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" name="active" id="showCheckboxActive" value="1" checked>
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
									<img src="{{ old('image') ? old('image') :  __NO_IMAGE_DEFAULT__ }}"
										data-init="{{ __NO_IMAGE_DEFAULT__ }}">
									<a href="javascript:void(0)" class="image__delete"
										onclick="urlFileDelete(this)">
										<i class="fa fa-times"></i></a>
									<input type="hidden" value="{{ old('image') }}" name="image" />
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