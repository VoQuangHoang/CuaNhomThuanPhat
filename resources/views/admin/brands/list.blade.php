@extends('admin.layouts.app')
@section('controller', 'Thương hiệu')
@section('controller_route', route('brands.index') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
				<form action="{!! route('brands.postMultiDel') !!}" method="POST">
			        @csrf
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên thương hiệu</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $item)
                                    <tr class="text-center">
                                        <td><input type="checkbox" name="chkItem[]" value="{{$item->id}}"></td>
                                        <td>{{$loop->index + 1 }}</td>
                                        <td><img src="{{!empty($item->image) ? $item->image : __NO_IMAGE_DEFAULT__}}" class="img-thumbnail" width="90px"></td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            @if ($item->status == 1 )
                                                <span class="badge badge-success">Hiển thị</span>
                                            @else
                                                <span class="badge badge-danger">Không hiển thị</span>
                                            @endif
                                            @if ($item->hot == 1 )
                                                <span class="badge badge-success">Nổi bật</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('brands.edit', $item->id )}}" title="Sửa" class="btn btn-sm btn-info btn-edit">
                                                <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy" data-href="{{route('brands.destroy', $item->id)}}"
                                                data-toggle="modal" data-target="#confim">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="btnAdd">
						<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn xóa không ?')"><i
			                        class="fa fa-trash-o"></i> Xóa các mục đã chọn
			            </button>
			        </div>
			    </form>
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