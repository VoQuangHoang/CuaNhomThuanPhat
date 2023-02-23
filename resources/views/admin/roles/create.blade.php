@extends('admin.layouts.app')
@section('controller','Vai trò')
@section('controller_route', route('users.index'))
@section('action','Thêm')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('roles.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên vai trò:</label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên vai trò" value="{!! old('name') !!}" required>
                        </div>
                        <div class="form-group">
                            <label>Chi tiết phân quyền:</label>
                            <div class="custom-control custom-checkbox listpermissioncheck mb-3">
                                <input name="elect" type="checkbox" value="true" id="checkAll" class="custom-control-input"> 
                                <label for="checkAll" class="custom-control-label">Chọn tất cả</label>
                            </div>
                            
                            <div class="permissionBox">
                                <hr class="mt-0">
                                @foreach($permission as $k => $item)
                                    
                                    <div class="custom-control custom-checkbox listpermissioncheck">
                                        <input name="permission[]" type="checkbox" id="defaultCheck{{$item['id']}}" class="custom-control-input"
                                        value="{{$item['id']}}" @if(in_array($item['id'],$oldPer)) checked @endif>
                                        <label for="defaultCheck{{$item['id']}}" class="custom-control-label" style="font-weight: 400;">
                                            {{$item['name']}}
                                        </label>
                                    </div>
                                    @if(($k+1)%4 == 0)
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-12 col-sm-3">
				<div class="card card-secondary card-outline">
					<div class="card-header">
						<h3 class="card-title">Thêm vai trò và phân quyền</h3>
					</div>
					<div class="card-body">
						<div class="text-right">
							<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </form>
</div>
@stop

@section('page_scripts')
    <script>
        $("#checkAll").click(function(){
            $('.permissionBox input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection

@section('page_css')
<style>
    .permissionBox{
        /* -webkit-column-width: 400px;
        -moz-column-width: 400px;
        column-width: 400px; */
        column-count: 3;
        column-gap: 40px;
    }
    .listpermissioncheck{
        display: block;
    }
</style>
@endsection