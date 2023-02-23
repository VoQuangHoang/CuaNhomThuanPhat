@extends('admin.layouts.app')
@section('controller','Tài khoản')
@section('action','Danh sách')
@section('controller_route', route('users.index'))
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
               	@include('flash::message')
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover dataTable dtr-inline">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên người dùng</th>
								<th>Số điện thoại</th>
								<th>Email</th>
								<th>Vai trò</th>
								<th>Trạng thái</th>
								<th width="120px">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
							<tr>
								<td>{{ $loop->index +1 }}</td>
								<td>
									@if (!empty($item->image))
										<img src="{{ $item->image }}"  width="30px" height="30px">
									@else
										<img src="{{ asset('backend/images/default.jpg') }}" width="30px" height="30px">
									@endif
									&nbsp;
									{{ $item->name }}
								</td>
								<td>{{ $item->phone }}</td>
								<td>{{ $item->email }}</td>
								
								<td>{{ !empty($item->roles[0]) ? $item->roles[0]->name : '' }}</td>
								<td>
									@if ($item->active == 1 )
										<span class="badge badge-success">Đang hoạt động</span>
									@else
										<span class="badge badge-danger">Đang khóa</span>
									@endif
								<td>
									
										<a href="{{ route('users.edit', $item->id ) }}" class="btn btn-sm btn-info btn-edit">
											<i class="fas fa-pencil-alt"></i> Sửa
										</a>
										<a href="javascript:;" class="btn btn-sm btn-danger btn-destroy" data-href="{{ route( 'users.destroy',  $item->id ) }}"
											data-toggle="modal" data-target="#confim">
											<i class="fas fa-trash"></i> Xóa
										</a>
								
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
           </div>
        </div>
	</div>
@stop