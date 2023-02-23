@extends('admin.layouts.app')
@section('controller', 'Các trang đơn')
@section('controller_route', route('pages.list') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                <div class="mb-3">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-default">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tên trang</th>
                                <th>Đường dẫn</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->name_page }}</td>
                                    <td>
                                        @if (Route::has($item->route))
                                        <a href="{{ route($item->route) }}" target="_blank" class="text-dark">
                                            <i class="far fa-hand-point-right" aria-hidden="true"></i>
                                            {{ route($item->route) }}
                                        </a>
                                        @else
                                        ---------------
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pages.build', ['page'=> $item->type ]) }}" 
                                            class="btn btn-success btn-sm btn-edit">
                                            <i class="far fa-edit"></i> Xây dựng trang
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
                                    <h4 class="modal-title">Add</h4>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span></button>
			                        
			                    </div>
			                    <div class="modal-body">
			                        <div class="form-group">
			                            <label for="">Name</label>
			                            <input type="text" name="name_page" class="form-control" required>
			                        </div>
			                        <div class="form-group">
			                            <label for="">Key</label>
			                            <input type="text" name="type" class="form-control" required>
			                        </div>
			                        <div class="form-group">
			                            <label for="">Route</label>
			                            <input type="text" name="route" class="form-control" required>
			                        </div>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			                        <button type="submit" class="btn btn-primary">Save</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</div>
		</div>
	</div>
@stop
