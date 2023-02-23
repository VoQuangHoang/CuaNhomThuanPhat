@extends('admin.layouts.app')
@section('controller', 'Đơn hàng')
@section('controller_route', route('admin.order.list') )
@section('action','Danh sách')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
            <form action="{!! route('admin.order.postMultiDel') !!}" method="POST">
                @csrf
				<div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                <th width="10px">STT</th>
                                <th>Mã đơn</th>
                                <th>SĐT</th>
                                <th>Phí ship</th>
                                <th>Giá giảm</th>
                                <th>Chiết khấu</th>
                                <th>Thanh toán</th>
                                <th>Ngày đặt</th>
                                <th width="80px">Trạng thái</th>
                                <th width="120px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $item)
                                <tr>
                                    <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                    <td>{{ count($order) - $loop->index }}</td>
                                    <td>{{$item->sku}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{number_format($item->shipping_fee, 0, 3, '.')}} đ</td>
                                    <td>{{number_format($item->sale_price, 0, 3, '.')}} đ</td>
                                    <td>{{number_format($item->discount_price, 0, 3, '.')}} đ</td>
                                    <td>{{number_format($item->total_price, 0, 3, '.')}} đ</td>
                                    <td>{{date_format($item->created_at,'d/m/Y')}}</td>
                                    <td>
                                        {!! $item->getStatusOrder($item->payment_type, $item->status) !!}
                                        <br>
                                        @if($item->vtp_order_number)
                                            <span class="badge bg-success">Mã vận đơn: {{$item->vtp_order_number}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.order.detail', $item->id)}}" class="btn btn-sm btn-info btn-edit" title="Chi tiết">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        <a href="javascript:;" class="btn btn-sm btn-danger btn-destroy"
                                                    data-href="{{route('admin.order.delete',$item->id )}}"
                                                    data-toggle="modal" data-target="#confim">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                        {{-- <a class="text-danger" href="{{route('backend.order.delete',$item->id )}}" onclick="return confirm('Bạn có chắc chắn xóa không ?')" title="Xóa"><span class="delete-action badge badge-danger">Xóa <i class="far fa-trash-alt"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="btnAdd">
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc chắn xóa không ?')"><i class="fa fa-trash-o"></i> Xóa mục
                        đã chọn
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
