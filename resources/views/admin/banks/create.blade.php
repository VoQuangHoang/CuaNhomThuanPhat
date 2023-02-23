@extends('admin.layouts.app')
@section('controller','Tài khoản ngân hàng')
@section('controller_route', route('banks.index'))
@section('action','Thêm')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('banks.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên tài khoản</label>
                            <input type="text" class="form-control" name="name" required placeholder="Nguyễn Văn  A" value="{!! old('name') !!}">
                        </div>
                        <div class="form-group">
                            <label>Số tài khoản</label>
                            <input type="text" class="form-control" name="number" required placeholder="0123456789" value="{!! old('number') !!}">
                        </div>
                        <div class="form-group">
                            <label>Ngân hàng</label>
                            <input type="text" class="form-control" name="bank" required placeholder="Vietcombank chi nhánh Đà Nẵng" value="{!! old('bank') !!}">
                        </div>
                        <div class="form-group">
                            <label>Cú pháp</label>
                            <input type="text" class="form-control" name="mess" required value="{!! old('mess') !!}">
                        </div>
    
                    
                    </div>
                </div>
            </div>
			<div class="col-12 col-sm-3">
				<div class="card card-secondary card-outline">
					<div class="card-header">
						<h3 class="card-title">Thêm tài khoản</h3>
					</div>
					<div class="card-body">
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" name="status" id="showCheckboxActive" value="1" checked>
								<label for="showCheckboxActive" class="custom-control-label">Hiển thị</label>
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