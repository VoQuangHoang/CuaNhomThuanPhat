@extends('admin.layouts.app')
@section('controller', 'Mã khuyến mãi')
@section('controller_route', route('coupons.index') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover dataTable dtr-inline">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                <th>STT</th>
                                <th>Mã</th>
                                <th>Tên mã</th>
                                <th>Mô tả</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Trạng thái</th>
                                <th width="150">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $item)
                                <tr>
                                    <td><input type="checkbox" name="chkItem[]" value="{{$item->id}}"></td>
                                    <td>{{$loop->index + 1 }}</td>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->desc}}</td>
                                    <td>
                                        @if ($item->type == 1 )
                                            <span class="badge badge-primary">Giảm theo %</span>
                                        @else
                                            <span class="badge badge-warning">Giảm theo giá tiền</span>
                                        @endif
                                    </td>
                                    <td>{{$item->value}}</td>
                                    <td>
                                        @if ($item->status == 1 )
                                            <span class="badge badge-success">Cho phép áp dụng</span>
                                        @else
                                            <span class="badge badge-danger">Không áp dụng</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('coupons.edit', $item->id )}}" title="Sửa" class="btn btn-sm btn-info btn-edit">
                                            <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy" data-href="{{route('coupons.destroy', $item->id)}}"
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
@section('page_css')
<style>
#example1 > tbody > tr > td {
     vertical-align: middle;
}
</style>
@endsection