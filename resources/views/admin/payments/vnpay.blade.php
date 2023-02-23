@extends('admin.layouts.app')
@section('controller', 'Thanh toán qua VNPAY')
@section('controller_route', route('payments.index'))
@section('action','Cấu hình')
@section('content')
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-secondary card-outline">
                <div class="card-body">
                    <form action="{{route('payments.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{$type}}">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Tiêu đề</label>
                                <input type="text" name="payment_name" class="form-control" value="{{ old('payment_name', @$data->payment_name) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Url khởi tạo GD</label>
                                <input type="text" name="url_pay" class="form-control" value="{{ old('url_pay', @$data->url_pay) }}" required>
                            </div>

                            <div class="form-group">
    
                                <label for="">Terminal ID(mã website)</label>
    
                                <input type="text" name="vnp_TmnCode" class="form-control" value="{{ old('vnp_TmnCode', @$data->vnp_TmnCode) }}" required>
    
                            </div>

                            <div class="form-group">
                                <label for="">SECRET KEY</label>
                                <input type="text" name="vnp_HashSecret" class="form-control" value="{{ old('vnp_HashSecret', @$data->vnp_HashSecret) }}" required>
                            </div>
                         
                            <div class="form-group">
                                <label for="">Url cập nhập trạng thái đơn hàng do VnPay trả về</label>
                                <input type="text" name="" class="form-control" value="{{ route('home.vnpayipn') }}" readonly>
                                <br>
                                <span class="label label-danger">*Lưu ý phải coppy url này và nhập vào IPN Url trong phần thông tin cấu hình thì mới cập nhập được trạng thái đơn hàng </span>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="status" type="checkbox" id="customCheckbox1" value="1" {{old('status', @$data->status) == 1 ? 'checked' : ''}}>
                                    <label for="customCheckbox1" class="custom-control-label">Kích hoạt</label>
                                    </div>
                            </div>
                            
                            <div class="form-group text-left mt-2">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu thay đổi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
