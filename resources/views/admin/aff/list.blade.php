@extends('admin.layouts.app')
@section('controller', 'Affiliate - Danh sách chiết khấu')
@section('controller_route', route('admin.affiliate.list') )
@section('action','Danh sách')
@section('content')
    <div class="container-fluid">
        <div class="card card-secondary card-outline">
            <div class="card-body">
                @include('flash::message')
                <form>
                    @csrf
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th>STT</th>
                                    <th>Affiliate ID</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Chiết khấu</th>
                                    <th>Loại</th>
                                    <th>Trạng thái</th>
                                    <th>Trạng thái đơn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value="{{$item->id}}"></td>
                                        <td>{{ count($data) - $loop->index }}</td>
                                        <td>
                                            <a href="{{route('customer.show', $item->customer->id)}}">{{ $item->customer->name}}</a><br>
                                            {{'ID: '.$item->customer->aff_id }}
                                        </td>
                                        <td>
                                            Mã đơn: <a href="{{route('admin.order.detail', $item->order->id)}}">{{ $item->order->sku}}</a>
                                            <br>
                                            {{'ID: '.$item->order->id }}
                                            <br>
                                            Người đặt: <a href="{{route('customer.show', $item->order->Customer->id)}}">{{ $item->order->name}}</a>
                                        </td>
                                        <td>{{ number_format($item->total_amount, 0, '', '.') }} ₫</td>
                                        <td>{{ number_format($item->aff_amount, 0, '', '.') }} ₫</td>
                                        <td>
                                            @if ($item->type == '1')
                                                <span class="badge badge-info">Đặt qua link aff</span>
                                            @else
                                                <span class="badge badge-secondary">Đặt qua mã giới thiệu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->withdraw == 1)
                                                <span class="badge badge-success">Đã rút</span>
                                            @else
                                                <span class="badge badge-warning">Chưa rút</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success">Đã hoàn thành</span>
                                            @else
                                                <span class="badge badge-danger">Chưa hoàn thành</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
			</div>
		</div>
	</div>
@stop
