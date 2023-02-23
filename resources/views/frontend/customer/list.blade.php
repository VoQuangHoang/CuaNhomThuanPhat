@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <div class="page-breadcrumb mb-4 mt-4">
            <a href="{{route('home.index')}}">Trang chủ</a>
            <span class="divide">/</span>
            <span class="last">Danh sách tài khoản thành viên</span>
        </div>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-order">
                    <h3>Tài khoản thành viên</h3>
                    <div class="table-responsive">
                        @if (count($data)>0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Tài khoản</th>
                                        <th>Doanh số gần nhất (T{{\Carbon\Carbon::now()->month}} - {{date('Y')}})</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                
                                <tbody class="align-middle">
                                    @foreach($data as $item) 
                                    <tr>
                                        <td>{{count($data) - $loop->index}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->CustomerRole ? $item->CustomerRole->name : 'Chờ xác nhận'}}</td>
                                        <td>{{number_format($item->CurrentMonth($item->id), 0,3,'.')}} ₫</td>
                                        <td>{{date_format($item->created_at,"d/m/Y")}}</td>
                                        <td>
                                            <a href="{{route('home.customer.detail', $item->id)}}" class="btn btn-detail btn-sm">Chi tiết</a>
                                            <div class="mt-1">
                                            <a href="javascript:void(0);" title="Cập nhật vai trò tài khoản thành viên" data-cusroleid="{{$item->customer_role_id}}" data-href="{{route('home.customer.update_role', $item->id)}}" data-bs-toggle="modal" data-bs-target="#editRoleCustomer" class="btn btn-detail btn-sm btn-edit-role">Cập nhật</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <span>Chưa có tài khoản thành viên</span>
                        @endif
                    </div>
                    <nav class="page-pagination mt-2">
                        {!! $data->links('vendor.pagination.bootstrap-5') !!}
                    </nav>
                </section>
            </div>
        </div>
        <!-- Modal -->
        
		<div class="modal fade" id="editRoleCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title fs-5">Cập nhật vai trò tài khoản thành viên</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="" method="POST" id="form-edit">
						@csrf
						@method('put')
						<div class="modal-body">
							<div class="form-group">
							    <label for="">Chọn vai trò</label>
                                <select class="form-control mt-1" name="customer_role_id" id="editCusRoleId" required>
                                    <option value="" disabled>Chọn</option>
                                    @foreach ($role as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success">Lưu lại</button>
							<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End Modal -->
    </div>
</main>
@stop

@section('page_script')
    <script>
        $(function () {
            $('body').on('click', '.btn-edit-role', function(event) {
                var action = $(this).attr('data-href');
                $('#form-edit').attr('action', action);
                $('#editCusRoleId').val($(this).data('cusroleid'));
            });
        });
    </script>
@endsection
