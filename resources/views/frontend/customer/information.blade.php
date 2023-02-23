@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="{{route('home.index')}}">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Tài khoản</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-info">
                    <h3>Tài khoản</h3>
                    <ul class="info-box list-unstyled mb-0">
                        <li>
                            <span>Thông tin tài khoản</span>
                            <strong>{{Auth::guard('customer')->user()->name}}</strong>
                            @if (Auth::guard('customer')->user()->customer_role_id)
                            <strong style="color:#e8bb65">&nbsp;-&nbsp;{{Auth::guard('customer')->user()->CustomerRole->name}}</strong>
                            @endif
                        </li>
                        <li>
                            <span>Email</span>
                            <strong>{{Auth::guard('customer')->user()->email}}</strong>
                        </li>
                        <li>
                            <span>Số điện thoại</span>
                            <strong>{{Auth::guard('customer')->user()->phone}}</strong>
                        </li>
                        <li>
                            <span>Mã giới thiệu</span>
                            <strong style="color:#a46e2e">{{Auth::guard('customer')->user()->referral_code}}</strong>
                        </li>
                    </ul>
                    <div class="action">
                        <a href="{{route('home.customer.info_update')}}">Cập nhật</a>
                    </div>
                </section>

                <section class="account-section account-order">
                    <h3>Các đơn vừa đặt</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày mua</th>
                                    <th>Sản phẩm</th>
                                    <th width="110">Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($orders))
                                    @foreach($orders as $order)    
                                    <tr>
                                        <td>{{$order->sku}}</td>
                                        <td>{{ date_format($order->created_at,"d/m/Y") }}</td>
                                        <td>
                                            @foreach($order->OrderDetail as $item)
                                                <div class="order-item">
                                                    <div @if($loop->index > 1) class="more-{{ $order->id }}" style="display: none;"  @endif>
                                                        <div class="title">{{$item->Product->name}}</div>
                                                        <span>Số lượng: {{$item->qty}}</span>
                                                        @if(count($item->OrderBonusProduct)>0)
                                                            <div class="mt-2 gift">
                                                                <i class="fas fa-gift"></i> Quà tặng:
                                                            </div>
                                                            @foreach ($item->OrderBonusProduct as $bonus)
                                                                {{$bonus->Product->name}} - Số lượng: {{$bonus->qty}}
                                                                <br>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if(count($order->OrderDetail) > 2)
                                                <a href="javascript:void(0);" id="xemthem-{{ $order->id }}" class="text-success" onclick="loadMore({{ $order->id }})">Xem thêm</a>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_price, 0, '', '.') }} đ</td>
                                        <td>
                                            {!! $order->getStatusOrder($order->payment_type, $order->status) !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có đơn hàng nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="account-section account-address">
                    <h3>Sổ địa chỉ</h3>
                    <div class="action">
                        <a href="{{route('home.customer.address')}}">Thêm Địa Chỉ Mới</a>
                    </div>
                    <div class="address-list">
                        @if(!empty($dataOrder))
                        @foreach($customerAddress as $cusAddress)
                        <div class="address-item">
                            <div class="title">{{$cusAddress->name}} - {{$cusAddress->phone}}
                                @if($cusAddress->type == 0)
                                    (Nhà riêng)
                                @else
                                    (Công ty)
                                @endif
                            </div>
                            <div class="detail">
                                {!! getFullAddressVTP($cusAddress) !!}
                            </div>

                            @if($cusAddress->is_default == 1 )
                                <div class="default">
                                    Địa chỉ mặc định
                                </div>
                            @else
                            <div class="action">
                                <a href="javascript:void(0);"></a>
                                <div class="action-box">
                                    <a href="{{ route('home.customer.set_address_default', $cusAddress->id) }}">Đặt làm mặc định</a>
                                    <a href="{{ route('home.customer.update_address',  $cusAddress->id) }}">Chỉnh sửa</a>
                                    <a href="{{ route('home.customer.delete_address',  $cusAddress->id) }}">Xoá</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <div class="address-item">
                            <p>Chưa có sổ địa chỉ</p>
                        <div>    
                        @endif
                    </div>
                    <nav aria-label="navigation">
                         {{-- {!! $customerAddress->links() !!} --}}
                    </nav>
                </section>
            </div>
        </div>

    </div>
</main>
<script>
    function loadMore(id) {
      var moreText = document.getElementsByClassName("more-" + id);
       Array.from(moreText).forEach((x) => {
            if (x.style.display === "none") {
            var xemthem = document.getElementById("xemthem-" + id).innerHTML = "Rút gọn";
              x.style.display = "block";
            } else {
              x.style.display = "none";
              var xemthem = document.getElementById("xemthem-" + id).innerHTML = "Xem thêm";
            }
          });
   }
</script>
@stop
