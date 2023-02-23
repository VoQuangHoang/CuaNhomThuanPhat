@extends('admin.layouts.app')
@section('controller', 'Phân quyền')
@section('controller_route', route('roles.index') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                <div class="mb-3">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-default">
                        <i class="fa fa-plus"></i> Thêm quyền
                    </button>
                    
                    <a href="{{ route('roles.create') }}">
			                <button class="btn btn-info"><i class="fa fa-plus"></i> Thêm vai trò</button>
			        </a>
                </div>
				<div class="table-responsive">
					<table id="table-ajax" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên vai trò</th>
								<th>Ngày tạo</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $item)
								<tr>
									<td>{{ $loop->index + 1 }}</td>
									<td>{{ $item->name }}</td>
									<td>{{ $item->created_at }}</td>
									<td>
										
										<a href="{{ route('roles.edit', $item->id ) }}" class="btn btn-sm btn-info btn-edit">
											<i class="far fa-edit"></i> Sửa 
										</a>
										
										<a href="javascript:;" class="btn btn-sm btn-danger btn-destroy" data-href="{{ route( 'roles.destroy',  $item->id ) }}"
											data-toggle="modal" data-target="#confim">
											<i class="far fa-trash-alt"></i> Xóa
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
                <div class="modal fade" id="modal-default">
			        <form action="{{ route('roles.addPermission') }}" method="POST">
			            {{ csrf_field() }}
			            <div class="modal-dialog">
			                <div class="modal-content">
			                    <div class="modal-header">
                                    <h4 class="modal-title">Thêm mới permissions</h4>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span></button>
			                        
			                    </div>
			                    <div class="modal-body">
			                        <div class="form-group">
			                            <label for="">Tên quyền</label>
			                            <input type="text" name="name" class="form-control" required autocomplete="off">
			                        </div>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Close</button>
			                        <button type="submit" class="btn btn-sm btn-primary">Lưu lại</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</div>
		</div>
	</div>
@stop
