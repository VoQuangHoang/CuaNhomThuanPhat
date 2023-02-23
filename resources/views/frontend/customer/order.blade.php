@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="{{route('home.index')}}">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Đơn hàng</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-order">
                    <h3>Đơn hàng của bạn</h3>
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
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->sku}}</td>
                                    <td>{{ date_format($order->created_at,"d/m/Y H:i") }}</td>
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
                                                            {{$bonus->Product->name}} - <span>Số lượng: {{$bonus->qty}}</span>
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
                                    <td>{{ number_format($order->total_price+$order->shipping_fee, 0, '', '.') }} đ</td>
                                    <td>
                                        {!! $order->getStatusOrder($order->payment_type, $order->status) !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav class="page-pagination customer-list mt-2">
                        {!! $orders->links('vendor.pagination.bootstrap-5') !!}
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
