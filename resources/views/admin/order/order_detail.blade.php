@extends('admin.layouts.app')
@section('controller','Đơn hàng chi tiết')
@section('controller_route', route('admin.order.list'))
@section('action','Cập nhật')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')


    <div class="row">
        <div class="col-12 col-sm-5">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <label>Chi tiết</label>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:40%">Khách hàng:</th>
                                        <td>{{$order->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại:</th>
                                        <td>{{$order->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{$order->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</th>
                                        <td><b>{!! $order->address !!} , {{ ucwords(\Str::lower($viettel_post->getDistrictById($order->city_id, $order->district_id))) }}, {{ $viettel_post->getProvinceById($order->city_id) }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Phí ship:</th>
                                        <td>{{number_format($order->shipping_fee, 0, 3, '.')}} đ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá giảm:</th>
                                        <td>{{number_format($order->sale_price, 0, 3, '.')}} đ</td>
                                    </tr>
                                    <tr>
                                        <th>Chiết khấu:</th>
                                        <td>{{number_format($order->discount_price, 0, 3, '.')}} đ</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng thanh toán:</th>
                                        <td>{{number_format($order->total_price, 0, 3, '.')}} đ</td>
                                    </tr>
                                    <tr>
                                        <th>Hình thức thanh toán:</th>
                                        <td>
                                            @if ($order->payment_type == 1)
                                                <span class="font-weight-bold">Thanh toán bằng tiền mặt (COD)</span>
                                            @elseif($order->payment_type == 2)
                                                <span class="font-weight-bold">Thanh toán qua chuyển khoản (BANK)</span>
                                            @elseif($order->payment_type == 3)
                                                <span class="font-weight-bold">Thanh toán VNPAY</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái đơn hàng:</th>
                                        <td>
                                            <h5>{!! $order->getStatusOrder($order->payment_type, $order->status) !!}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày đặt</th>
                                        <td>
                                            {{ date_format($order->created_at, 'd/m/Y h:i') }} ({{ time_elapsed_string($order->created_at) }})
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mã vận đơn ViettelPost</th>
                                        <td>
                                            @if (!empty($order->vtp_order_number))
                                                <h5><span class="badge bg-success">Đã đẩy đơn - Mã: {{$order->vtp_order_number}}</span></h5>
                                            @else
                                                <h5><span class="badge bg-danger">Chưa đẩy đơn</span></h5>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            @if ($order->payment_type == 3)
                                <button type="button" class="btn btn-sm btn-success disabled"><i class="fas fa-check"></i> Cập nhật đơn hàng</button>
                            @else
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateStatus"><i class="fas fa-check"></i> Cập nhật đơn hàng</button>
                            @endif
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#postViettel"><i class="fas fa-shipping-fast"></i> Đẩy đơn ViettelPost</button>
                        </div>

                    </div>
                    <div class="card-footer">
                        <span class="text-danger">Chú ý:</span>
                        <span>Vui lòng xóa đơn đã đẩy trên hệ thống <a href="https://viettelpost.com.vn/" target="_blank">ViettelPost</a> và tiến hành đẩy lại đơn nếu muốn để tránh đẩy trùng đơn</span>
                    </div>
                </div>
        </div>
        <div class="col-12 col-sm-7">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h4 class="card-title">Danh sách sản phẩm</h4>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                <th width="10px">STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>KL</th>
                                <th>SL</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_detail as $item)
                                <tr>
                                    <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{ $item->Product->name }}
                                        <br>
                                        @if(count($item->OrderBonusProduct)>0)
                                            <div class="mt-2">
                                                <i class="fas fa-gift"></i> Quà tặng:
                                            </div>
                                            @foreach ($item->OrderBonusProduct as $bonus)
                                                {{$bonus->Product->name}} - <span>Số lượng: {{$bonus->qty}}</span>
                                                <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{number_format($item->price, 0, 3, '.')}}đ</td>
                                    <td>{{ $item->Product->weight}}g</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{number_format($item->total_price, 0, 3, '.')}}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateStatus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateStatusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusLabel">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p><span class="text-danger">*</span>Chọn trạng thái <small>(kiểm tra đơn hàng trước khi cập nhật)</small></p>
                    <select class="form-control" name="pro_status" id="">
                        <option value="1" {{$order->status == 1 ? 'selected' : ''}}>Mới đặt</option>
                        <option value="2" {{$order->status == 2 ? 'selected' : ''}}>Xác nhận</option>
                        <option value="3" {{$order->status == 3 ? 'selected' : ''}}>Đang giao hàng</option>
                        <option value="4" {{$order->status == 4 ? 'selected' : ''}}>Đã hoàn thành</option>
                        <option value="5" {{$order->status == 5 ? 'selected' : ''}}>Đã hủy</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success">Lưu lại</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="postViettel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="postViettelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form id="formVTP" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                <input type="hidden" name="url_select_store" id="url_select_store" value="{{route('admin.order.vtpSelectStore')}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="postViettelLabel">Đăng đơn hàng lên ViettelPost</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-danger text-danger" id="vtp_error_callout">
                        <p class="text-danger" id="vtp_error">Vui lòng chọn kho lấy hàng để tiếp tục</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h4 class="card-title">Chọn kho gửi</h4>
                                </div>
                                <div class="card-body">
                                    <select class="form-control" id="vtp_select_store" name="store_id">
                                        <option value="">Chọn</option>
                                        @foreach ($storeAll as $item)
                                            <option value="{{$item['groupaddressId']}}" title="{{$item['address']}}">{{$item['name']}} - {{$item['address']}} ({{$item['groupaddressId']}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h4 class="card-title">Thông tin người nhận</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Họ và tên</b>
                                            <span class="float-right">{{$order->name}}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Số điện thoại:</b>
                                            <span class="float-right">{{$order->phone}}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Địa chỉ:</b>
                                            <span class="float-right">{!! $order->address !!} , {{ ucwords(\Str::lower($viettel_post->getDistrictById($order->city_id, $order->district_id))) }}, {{ $viettel_post->getProvinceById($order->city_id) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h4 class="card-title">Dịch vụ</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <select class="form-control" name="vtp_service" id="vtp_service">
                                        <option value="VCN" @if($order->payment_type == 3) selected @endif>Vận chuyển nhanh (Không áp dụng thu hộ)</option>
                                        <option value="LCOD" @if($order->payment_type != 3) selected @endif>TMĐT Tiết kiệm (Áp dụng thu hộ)</option>
                                    </select> --}}
                                    <div id="view_service">

                                    </div>
                                </div>
                            </div>
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h4 class="card-title">Chú ý</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="pl-3">
                                        <li>Điều chỉnh khối lượng và chọn lại dịch vụ phù hợp với đơn hàng</li>
                                        <li>Giá vận chuyển có thể chênh lệch so với đơn hàng ban đầu</li>
                                        <li>Tiền thu hộ (nếu có) là tiền khách thanh toán trước đó lưu trên hệ thống, không phụ thuộc giá cước trên</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h4 class="card-title">Thông tin sản phẩm</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" class="form-control" name="name_concat" value="{{$nameProduct}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Khối lượng (gram):</label>
                                        <input type="number" class="form-control" name="weight" value="{{$order->total_weight}}" placeholder="gram" id="total_weight">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kích thước (cm):</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Dài</span>
                                                <input type="number" class="form-control" name="length" value="0" id="product_length">
                                            </div>
                                            <div class="col-md-4">
                                                <span>Rộng</span>
                                                <input type="number" class="form-control" name="width" value="0" id="product_width" >
                                            </div>
                                            <div class="col-md-4">
                                                <span>Cao</span>
                                                <input type="number" class="form-control" name="height" value="0" id="product_height">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Trọng lượng quy đổi (dài x rộng x cao : 6000 - đơn vị kg)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="weight_calc" id="weight_calc" disabled readonly placeholder="Trọng lượng quy đổi từ kích thước hàng hóa">
                                            <div class="input-group-append">
                                                <span class="input-group-text">gram</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="card card-secondary">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>TIỀN THU HỘ <small>(áp dụng cho đơn hàng ship COD - Thanh toán bằng tiền mặt)</small></label>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="check_money_collection" id="check_money_collection" value="1" @if($order->payment_type == 1) checked @endif>
                                            <label for="check_money_collection" class="custom-control-label">Thu hộ tiền hàng</label>
                                        </div>
                                        <div class="mt-2">
                                            <input type="number" class="form-control" value="{{$order->total_price - $order->shipping_fee}}" readonly disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>GHI CHÚ</label>
                                        <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)" rows="2">{!! $order->note !!}</textarea>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>         
                    
                    <div class="card card-secondary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tiền cước (đ)</label>
                                        <input type="number" class="form-control" name="vtp_shipping_price" value="{{$order->shipping_fee}}" id="vtp_shipping_price" readonly disabled>
                                        {{-- <p>Vận chuyển nhanh: <span id="vtp_shipping_price">{{$order->shipping_fee}}</span></p> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tổng tiền thu hộ (đ)</label>
                                        <input type="number" class="form-control" name="money_collection" value="{{$order->total_price}}" id="money_collection">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success" id="vtp_btn_create" data-route="{{route('admin.order.vtpCreateBill')}}" disabled>Đăng đơn</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
