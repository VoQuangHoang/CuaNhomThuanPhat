@extends('admin.layouts.app')
@section('controller', 'Danh mục sản phẩm')
@section('controller_route', route('product-categories.index') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
				
					<form action="{{ route('product-categories.postMultiDel') }}" method="POST">
						@csrf
						<div class="table-responsive">
						<table id="example1" class="table table-bordered">
							<thead>
							<tr>
								<th><input type="checkbox" name="chkAll" id="chkAll"></th>
								<th>Tiêu đề</th>
								<th>Số danh mục con</th>
								<th>Trạng thái</th>
								<th>Thao tác</th>
							</tr>
							</thead>
							<tbody>
								<?php listCate($categories); ?>
							</tbody>
						</table>
						<div class="btnAdd">
							<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn xóa không ?')"><i
										class="fa fa-trash-o"></i> Xóa các mục đã chọn
							</button>
						</div>
						</div>
					</form>
				
			</div>
		</div>
	</div>
@stop
