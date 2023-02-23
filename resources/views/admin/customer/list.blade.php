@extends('admin.layouts.app')
@section('controller','Tài khoản người dùng')
@section('action','Danh sách')
@section('controller_route', route('customer.index'))
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
               	@include('flash::message')
           		{{-- <div class="btnAdd">
			      	<a href="{{ route('customer.create') }}">
			          	<button type="button" class="btn btn-dark"><i class="fa fa-plus"></i> Thêm tài khoản</button>
			      	</a>
			    </div> --}}
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover dataTable dtr-inline">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên tài khoản</th>
								<th>Tên người dùng</th>
								<th>Số điện thoại</th>
								<th>Email</th>
								<th>Đối tác</th>
								<th>Affiliate</th>
								<th>Trạng thái</th>
								<th width="220">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
							<tr>
								<td>{{ $loop->index +1 }}</td>
								<td class="text-center">
									@if (!empty($item->image))
										<img src="{{ url('/frontend/avatar').'/'.$item->image }}"  width="50px">
									@else
										<img src="{{ asset('backend/images/default.jpg') }}" width="50px">
									@endif
									&nbsp; &nbsp;
									{{ $item->user_name }}
								</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->phone }}</td>
								<td>{{ $item->email }}</td>
								<td>{{ !empty($item->CustomerRole) ? $item->CustomerRole->name : 'Chưa có' }}</td>
								<td>
									@if ($item->is_aff == 1 )
										<span class="badge badge-success">Đã đăng ký</span>
									@else
										<span class="badge badge-danger">Chưa đăng ký</span>
									@endif
								</td>
								<td>
									@if ($item->confirmed == 1 )
										<span class="badge badge-success">Đã xác nhận</span>
									@else
										<span class="badge badge-danger">Chưa xác nhận</span>
									@endif
								<td>
									<a href="{{ route('customer.show', $item->id ) }}" class="btn btn-sm btn-info btn-edit">
										<i class="fas fa-eye"></i> Xem 
									</a>
									<a href="javascript:void(0);" data-href="{{ route('customer.update', $item->id ) }}"
										class="btn btn-sm btn-warning btn-edit" data-cusroleid="{{$item->customer_role_id}}" title="Edit" data-toggle="modal" data-target="#editCate">
										<i class="fas fa-pencil-alt"></i> Cập nhật vai trò
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
           </div>
        </div>
		<!-- Modal -->
        
		<div class="modal modal__menu" id="editCate">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật vai trò người dùng</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<form action="" method="POST" id="form-edit">
						@csrf
						@method('put')
						<div class="modal-body">
							<div class="form-group">
							  <label for=""></label>
							  <select class="form-control" name="customer_role_id" id="editCusRoleId" required>
								<option value="">Chọn</option>
								@foreach ($cus_role as $item)
									<option value="{{$item->id}}">{{$item->name}}</option>
								@endforeach
							  </select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success">Lưu lại</button>
							<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End Modal -->
	</div>
@stop

@section('page_scripts')
    <script>
        $(function () {
            $('body').on('click', '.btn-edit', function(event) {
                var action = $(this).attr('data-href');
                $('#form-edit').attr('action', action);
                $('#editCusRoleId').val($(this).data('cusroleid'));
            });
        });
    </script>
@endsection