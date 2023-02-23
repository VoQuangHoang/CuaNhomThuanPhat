@extends('admin.layouts.app')
@section('controller', 'Affiliate - Yêu cầu rút tiền')
@section('controller_route', route('admin.affiliate.list_request') )
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
                                    <th>Tổng tiền</th>
                                    <th>Ngân hàng</th>
                                    <th>Số tài khoản</th>
                                    <th>Tên tài khoản</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value="{{$item->id}}"></td>
                                        <td>{{ count($data) - $loop->index }}</td>
                                        <td>
                                            {{ $item->customer->name}} <br>
                                            {{'ID: '.$item->customer->aff_id }}
                                        </td>
                                        <td>{{ number_format($item->amount, 0, '', '.') }} ₫</td>
                                        <td>{{ $item->bank_name }}</td>
                                        <td>
                                            {{ $item->bank_number }}
                                        </td>
                                        <td>
                                            {{ $item->holder_name }}
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success">Đã duyệt và thanh toán</span>
                                            @else
                                                <span class="badge badge-warning">Yêu cầu chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <a class="btn btn-sm btn-success">Đã duyệt</a>
                                            @else
                                                <a href="javascript:void(0);" class="btn-edit btn-confirm" 
                                                    data-href="{{route('admin.affiliate.process', $item->id)}}" data-toggle="modal" data-target="#confirm_aff">
                                                    <span class="btn btn-sm btn-success">Xác nhận thanh toán</span>
                                                </a>
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
