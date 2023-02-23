@extends('admin.layouts.app')
@section('controller', 'Nhóm menu')
@section('controller_route', route('setting.menu.list') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                {{-- <div class="btnAdd">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-default">
                        <i class="fa fa-plus"></i> Thêm
                    </button>
                </div> --}}
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tiêu đề</th>
								<th>Vị trí</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							@foreach($menu as $item)
								<tr>
									<td>{{ $loop->index + 1 }}</td>
									<td>{{ $item->title }}</td>
									<td>{{ $item->position }}</td>
									<td>
										<a href="{{route('setting.menu.edit', $item->id)}}" class="btn btn-sm btn-info btn-edit">
											<i class="far fa-edit"></i> Chỉnh sửa
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
                <div class="modal fade" id="modal-default">
			        <form action="{{ route('pages.create') }}" method="POST">
			            {{ csrf_field() }}
			            <div class="modal-dialog">
			                <div class="modal-content">
			                    <div class="modal-header">
                                    <h4 class="modal-title">Thêm mới</h4>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span></button>
			                        
			                    </div>
			                    <div class="modal-body">
			                        <div class="form-group">
			                            <label for="">Tiêu đề trang</label>
			                            <input type="text" name="name_page" class="form-control" required>
			                        </div>
			                        <div class="form-group">
			                            <label for="">Key</label>
			                            <input type="text" name="type" class="form-control" required>
			                        </div>
			                        <div class="form-group">
			                            <label for="">Route name</label>
			                            <input type="text" name="route" class="form-control" required>
			                        </div>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			                        <button type="submit" class="btn btn-primary">Lưu lại</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</div>
		</div>
	</div>
@stop