@extends('admin.layouts.app')
@section('controller','Tài khoản ngân hàng')
@section('action','Danh sách')
@section('controller_route', route('banks.index'))
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
               	@include('flash::message')
           		<div class="mb-3">
			      	<a href="{{ route('banks.create') }}">
			          	<button type="button" class="btn btn-dark"><i class="fa fa-plus"></i> Thêm tài khoản</button>
			      	</a>
			    </div>
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover dataTable dtr-inline">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên tài khoản</th>
								<th>Số tài khoản</th>
								<th>Ngân hàng</th>
								<th width="20%">Cú pháp</th>
								<th>Trạng thái</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
							<tr>
								<td>{{ $loop->index +1 }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->number }}</td>
								<td>{{ $item->bank }}</td>
								<td>{{ $item->mess }}</td>
								<td class="text-center">
									@if ($item->status == 1 )
										<span class="badge badge-success">Hiển thị</span>
									@else
										<span class="badge badge-danger">Không hiển thị</span>
									@endif
								<td>
									<a href="{{ route('banks.edit',$item->id ) }}"
										class="btn btn-sm btn-info btn-edit" title="Edit">
										<i class="fas fa-pencil-alt"></i> Chỉnh sửa
									</a>
									<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy"
										data-href="{{ route('banks.destroy', $item->id) }}"
										data-toggle="modal" data-target="#confim" title="Delete">
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