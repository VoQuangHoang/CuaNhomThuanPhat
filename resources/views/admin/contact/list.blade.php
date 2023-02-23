@extends('admin.layouts.app')
@section('controller', 'Liên hệ')
@section('controller_route', route('contacts.index') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                <form action="{{route('contacts.postMultiDel')}}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Nội dung</th>
                                    <th>Loại</th>
                                    <th>Trạng thái</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contact as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value=" {{$item->id}}"></td>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->message }}</td>
                                        <td>{{ $item->type}}</td>
                                        <td>
                                        @if ($item->status == 1)
                                            <span class="badge badge-success">Đã xem</span>
                                        @else
                                            <span class="badge badge-warning">Chưa xem</span>
                                        @endif
                                        </td>
                                        <td>
                                            
                                            <a href="{{route('contacts.edit', $item->id)}}" class="btn btn-sm btn-success btn-edit" title="Cập nhật trạng thái">
                                                <i class="fas fa-check"></i> Đã xem
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy" data-href="{{route('contacts.destroy', $item->id)}}" data-toggle="modal" data-target="#confim" title="Delete">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Confirm want to delete ?')"><i class="fa fa-trash-o"></i> Xóa các mục đã chọn
                        </button>
                    </div>
                </form>
			</div>
		</div>
	</div>
@stop
