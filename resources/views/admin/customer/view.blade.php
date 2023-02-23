@extends('admin.layouts.app')
@section('controller','Tài khoản')
@section('controller_route', route('customer.index'))
@section('action','Chỉnh sửa')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('users.update', $data->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-4">

                <div class="card card-dark card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
							@if (!empty($data->image))
								<img class="profile-user-img img-fluid img-circle" src="{{ url('/frontend/avatar').'/'.$data->image }}"
							alt="User profile picture">
							@else
								<img class="profile-user-img img-fluid img-circle" src="{{ asset('backend/images/default.jpg') }}"
							alt="User profile picture">
							@endif
                        </div>
                        <h3 class="profile-username text-center">{{ $data->name }}</h3>
						@if ($data->customer_role_id)
							<p class="text-muted text-center">{{$data->CustomerRole->name}}</p>
						@endif
                        
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>SĐT</b> <a class="float-right">{{ $data->phone }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $data->email }}</a>
                            </li>
							<li class="list-group-item">
                                <b>Trạng thái</b> 
								<a class="float-right">
									@if ($data->confirmed == 1 )
			    					<span class="badge badge-success">Đã xác nhận</span>
									@else
										<span class="badge badge-danger">Chưa xác nhận</span>
									@endif
								</a>
                            </li>
							<li class="list-group-item">
                                <b>Affiliate</b>
								<a class="float-right">
									@if ($data->is_aff == 1 )
			    					<span class="badge badge-success">Đã đăng ký</span>
									@else
										<span class="badge badge-warning">Chưa đăng ký</span>
									@endif
								</a>	
                            </li>
                        </ul>
                    </div>
                </div>

				<div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Sổ địa chỉ</h3>
                    </div>

                    <div class="card-body">
						@if(count($data->Address) > 0)
							@foreach($data->Address as $item)
							<strong><i class="fas fa-map-marker-alt mr-1"></i> Vị trí</strong>
							<p class="text-muted">{{$item->address}}, {{$item->Ward->path_with_type}} @if($item->is_default == 1) (Mặc định) @endif</p>
							<hr>
							@endforeach
						@else
							<p class="text-muted">Chưa có địa chỉ</p>
                        @endif
                    </div>

                </div>
            </div>
			
			<div class="col-md-8">
				<div class="card card-dark">
					<div class="card-header">
					<h3 class="card-title">Tài khoản thành viên</h3>
					</div>
					
					<div class="card-body">
						<div class="table-responsive">
							<table id="example1" class="table table-bordered table-hover w-100">
								<thead>
									<tr>
										<th>STT</th>
										<th>Tên</th>
										<th width="100">Tài khoản</th>
										<th>Doanh số gần nhất <br>(T{{\Carbon\Carbon::now()->month}} - {{date('Y')}})</th>
										<th>Ngày tạo</th>
										<th>Hành động</th>
									</tr>
								</thead>
								<tbody>
									@if(count($member)>0)
										@foreach($member as $item) 
										<tr>
											<td>{{count($member) - $loop->index}}</td>
											<td>{{$item->name}}</td>
											<td>{{$item->CustomerRole ? $item->CustomerRole->name : 'Chờ xác nhận'}}</td>
											<td>{{number_format($item->CurrentMonth($item->id), 0,'','.')}} ₫</td>
											<td>{{date_format($item->created_at,"d/m/Y")}}</td>
											<td>
												<a href="{{ route('customer.show', $item->id ) }}" class="btn btn-info btn-sm">Chi tiết</a>
											</td>
										</tr>
										@endforeach
									@else
										<tr>
											<td colspan="6" class="text-center">Chưa có tài khoản thành viên</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					
					{{-- <div class="card-footer clearfix">
					</div> --}}
				</div>

				<div class="card card-dark">
					<div class="card-header">
					<h3 class="card-title">Doanh số (theo tháng - năm {{date('Y')}})</h3>
					</div>
					
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Tháng</th>
										<th>Số hóa đơn trong tháng</th>
										<th>Phí (vận chuyển, giảm giá, chiết khấu)</th>
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
					</div>
					
					{{-- <div class="card-footer clearfix">
					</div> --}}
				</div>

				<div class="card card-dark">
					<div class="card-header">
					<h3 class="card-title">Doanh số (theo quý - năm {{date('Y')}}, theo từng năm)</h3>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Tháng</th>
										<th>Số hóa đơn trong tháng</th>
										<th>Phí (vận chuyển, giảm giá, chiết khấu)</th>
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
					</div>
					
					{{-- <div class="card-footer clearfix">
					</div> --}}
				</div>

				<div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Đơn hàng gần nhất</h3>
                    </div>

                    <div class="card-body">
						<div class="table-responsive">
							<table id="example1" class="table table-bordered table-striped table-hover w-100">
								<thead>
									<tr>
										<th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
										<th width="10px">STT</th>
										<th>Mã đơn</th>
										<th>Thanh toán</th>
										<th width="90px">Ngày đặt</th>
										<th>Trạng thái</th>
										<th>Thao tác</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data->CustomerOrders->sortByDesc('created_at') as $item)
										<tr>
											<td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
											<td>{{ count($data->CustomerOrders) - $loop->index }}</td>
											<td>{{$item->sku}}</td>
											<td>{{number_format($item->total_price, 0, 3, '.')}} đ</td>
											<td>{{date_format($item->created_at, 'd-m-Y')}} <br> {{ '('.time_elapsed_string($item->created_at).')' }}</td>
											<td>
												{!! $item->getStatusOrder($item->payment_type, $item->status) !!}
											</td>
											<td>
												<a href="{{route('admin.order.detail', $item->id)}}" class="btn btn-sm btn-info" title="Chi tiết">
													<i class="fas fa-eye"></i> Xem
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
                    </div>

                </div>

				
				
					
				
			</div>

			
        </div>
    </form>

</div>
@stop
