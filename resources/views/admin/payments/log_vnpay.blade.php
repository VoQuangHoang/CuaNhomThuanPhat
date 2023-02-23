@extends('admin.layouts.app')
@section('controller', 'Lịch sử giao dịch VNPAY')
@section('controller_route', route('admin.order.list') )
@section('action','Danh sách')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
                <table id="example1" class="table table-bordered table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                            <th width="10px">STT</th>
                            <th width="80px">Mã giao dịch</th>
                            <th>Mã đơn hàng</th>
                            <th>Số tiền</th>
                            <th>Ngân hàng</th>
                            <th>Nội dung thanh toán</th>
                            <th>Ngày tạo</th>
                            <th width="80px">Trạng thái</th>
                            <th width="120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                <td>{{ count($data) - $loop->index }}</td>
                                <td>{{ $item->ma_gd }}</td>
                                <td>{{ $item->ma_dh }}</td>
                                <td>{{number_format($item->so_tien, 0, 3, '.')}}đ</td>
                                <td>{{ $item->ngan_hang }}</td>
                                <td>{{ $item->noidung_tt }}</td>
                                <td>{{ format_datetime($item->ngay_tao,'d-m-Y H:i:s') }}</td>
                                <td>{{ $item->vnPayStatus->mo_ta }}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-sm btn-danger btn-destroy"
                                        data-href="{{route('payments.log_vnpay.delete',$item->id )}}"
                                        data-toggle="modal" data-target="#confim">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                    {{-- <a class="text-danger" href="{{route('backend.order.delete',$item->id )}}" onclick="return confirm('Bạn có chắc chắn xóa không ?')" title="Xóa"><span class="delete-action badge badge-danger">Xóa <i class="far fa-trash-alt"></i></a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="btnAdd">
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc chắn xóa không ?')"><i class="fa fa-trash-o"></i> Xóa mục
                        đã chọn
                    </button>
                </div> --}}
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
