@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="{{route('home.index')}}">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Đổi mật khẩu</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-info">
                    <h3>Chi tiết thành viên</h3>
                    <ul class="info-box list-unstyled mb-0">
                        <li>
                            <span>Tài khoản</span>
                            <strong>{{$customer->name}}</strong>
                            @if ($customer->customer_role_id)
                            <strong style="color:#a46e2e">&nbsp;-&nbsp;{{$customer->CustomerRole->name}}</strong>
                            @endif
                        </li>
                        <li>
                            <span>Email</span>
                            <strong>{{$customer->email}}</strong>
                        </li>
                        <li>
                            <span>Số điện thoại</span>
                            <strong>{{$customer->phone}}</strong>
                        </li>
                        
                    </ul>
                    <div class="action">
                        <a href="{{route('home.customer.info_update')}}">Cập nhật</a>
                    </div>
                </section>

                <section class="account-section account-order">
                    <h3>Doanh số (theo tháng - năm {{date('Y')}})</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tháng</th>
                                    <th>Số hóa đơn trong tháng</th>
                                    <th>Phí <small>(vận chuyển, giảm giá, chiết khấu)</small></th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($orderByMonth)>0)
                                @foreach ($orderByMonth as $orderMonth)
                                    <tr>
                                        <td>{{$orderMonth->monthname}}</td>
                                        <td>{{$orderMonth->count}}</td>
                                        <td>{{number_format($orderMonth->total_shipping+$orderMonth->total_discount+$orderMonth->total_sale, 0, '', '.')}} ₫</td>
                                        <td>{{number_format($orderMonth->total_price-($orderMonth->total_shipping+$orderMonth->total_discount+$orderMonth->total_sale), 0, '', '.')}} ₫</td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">Chưa có đơn hàng nào</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="account-section account-order">
                    <h3>Doanh số (theo quý - năm {{date('Y')}}, theo từng năm)</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Theo</th>
                                    <th>Số hóa đơn trong quý</th>
                                    <th>Phí <small>(vận chuyển, giảm giá, chiết khấu)</small></th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Quý 1 <small>(T1-T3)</small></td>
                                    <td>{{$orderMonth1->sum('count')}}</td>
                                    <td>{{number_format($orderMonth1->sum('total_shipping')+$orderMonth1->sum('total_discount')+$orderMonth1->sum('total_sale'), 0, '', '.')}} ₫</td>
                                    <td>{{number_format($orderMonth1->sum('total_price')-($orderMonth1->sum('total_shipping')+$orderMonth1->sum('total_discount')+$orderMonth1->sum('total_sale')), 0, '', '.')}} ₫</td>
                                </tr>
                                <tr>
                                    <td>Quý 2 <small>(T4-T6)</small></td>
                                    <td>{{$orderMonth2->sum('count')}}</td>
                                    <td>{{number_format($orderMonth2->sum('total_shipping')+$orderMonth2->sum('total_discount')+$orderMonth2->sum('total_sale'), 0, '', '.')}} ₫</td>
                                    <td>{{number_format($orderMonth2->sum('total_price')-($orderMonth2->sum('total_shipping')+$orderMonth2->sum('total_discount')+$orderMonth2->sum('total_sale')), 0, '', '.')}} ₫</td>
                                </tr>
                                <tr>
                                    <td>Quý 3 <small>(T7-T9)</small></td>
                                    <td>{{$orderMonth3->sum('count')}}</td>
                                    <td>{{number_format($orderMonth3->sum('total_shipping')+$orderMonth3->sum('total_discount')+$orderMonth3->sum('total_sale'), 0, '', '.')}} ₫</td>
                                    <td>{{number_format($orderMonth3->sum('total_price')-($orderMonth3->sum('total_shipping')+$orderMonth3->sum('total_discount')+$orderMonth3->sum('total_sale')), 0, '', '.')}} ₫</td>
                                </tr>
                                <tr>
                                    <td>Quý 4 <small>(T10-T12)</small></td>
                                    <td>{{$orderMonth4->sum('count')}}</td>
                                    <td>{{number_format($orderMonth4->sum('total_shipping')+$orderMonth4->sum('total_discount')+$orderMonth4->sum('total_sale'), 0, '', '.')}} ₫</td>
                                    <td>{{number_format($orderMonth4->sum('total_price')-($orderMonth4->sum('total_shipping')+$orderMonth4->sum('total_discount')+$orderMonth4->sum('total_sale')), 0, '', '.')}} ₫</td>
                                </tr>
                                @foreach ($orderYear as $item)
                                <tr>
                                    <td>Năm {{$item->year}}</td>
                                    <td>{{$item->count}}</td>
                                    <td>{{number_format($item->total_shipping+$item->total_discount+$item->total_sale, 0, '', '.')}} ₫</td>
                                    <td>{{number_format($item->total_price-($item->total_shipping+$item->total_discount+$item->total_sale), 0, '', '.')}} ₫</td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="account-section account-order">
                    <h3>Đơn hàng <small>(lấy theo đơn gần nhất)</small></h3>
                    @if(count($orders)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:110px">Mã đơn hàng</th>
                                    <th width=120>Ngày mua</th>
                                    <th>Sản phẩm</th>
                                    <th width="100">Tổng tiền</th>
                                    <th style="width:100px">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    @foreach($orders as $order)    
                                    <tr>
                                        <td>{{ $order->sku }}</td>
                                        <td>
                                            {{ date_format($order->created_at,"d/m/Y") }}
                                            <br>
                                            {{ '('.time_elapsed_string($order->created_at).')' }}
                                        </td>
                                        <td>
                                            @foreach($order->OrderDetail as $od)
                                                <p @if($loop->index > 1) class="more-{{ $order->id }}" style="display: none;"  @endif>
                                                    {{$od->Product->name}}
                                                    <br><span>Số lượng: {{$od->qty}}</span>
                                                </p>
                                            @endforeach
                                            
                                            @if(count($order->OrderDetail) > 2)
                                                <a href="javascript:void(0);" id="xemthem-{{ $order->id }}" style="color:#3AAD61" onclick="loadMore({{ $order->id }})">Xem thêm</a>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_price, 0, '', '.')}} ₫</td>
                                        <td>
                                            {!! $order->getStatusOrder($order->payment_type, $order->status) !!}
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <span>Chưa có đơn hàng nào</span>
                    @endif
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
