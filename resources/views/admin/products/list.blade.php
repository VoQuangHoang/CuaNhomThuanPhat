@extends('admin.layouts.app')
@section('controller', 'Sản phẩm')
@section('controller_route', route('products.index') )
@section('action','Danh sách')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
            <div class="row mb-3">
                <div class="col-12 col-lg-12">
                    <div class="row-action search">
                        <form action="{{route('products.index')}}" class="product-search" id="product-search" method="GET">
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <select name="author" id="" value="{{old('author')}}" class="form-control">
                                            <option value="">Tất Cả Thành Viên</option>
                                            @if (!empty($users))
                                                @foreach ($users as $user)
                                                    <option value="{{$user->id}}" {{Request::get('author') == $user->id ? 'selected': ''}}>{{$user->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <select name="status" id="" class="form-control" required>
                                            <option disabled>Trạng thái</option>
                                            <option value="" {{Request::get('status') == '' ? 'selected': ''}}>Tất cả</option>
                                            <option value="1" {{Request::get('status') == 1 ? 'selected': ''}}>Công khai</option>
                                            <option value="2" {{Request::get('status') == 2 ? 'selected': ''}}>Chờ duyệt</option>
                                            <option value="3" {{Request::get('status') == 3 ? 'selected': ''}}>Thùng rác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <select name="category" id="" class="form-control">
                                            <option value="">Chuyên mục</option>
                                            @if (!empty($categories))
                                                @foreach ($categories as $cate)
                                                    <option value="{{$cate->id}}" {{Request::get('category') == $cate->id ? 'selected': ''}}>{{$cate->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="daterange" autocomplete="off" placeholder="Chọn khoảng thời gian" value="{{old('daterange',Request::get('daterange'))}}" class="form-control float-right" id="reservation">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <input id="form-title" name="keyword" value="{{old('keyword',Request::get('keyword'))}}" type="text" placeholder="Nhập từ khóa..." class="form-control" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-12 col-md-2"><button class="form-control btn btn-outline-secondary"  id="btn-submit-search" type="button">Tìm kiếm</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form action="{!! route('products.postMultiMoveTrash') !!}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                <th width="10px">STT</th>
                                <th width="80px">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Người tạo</th>
                                <th>Danh mục</th>
                                <th width="80px">Trạng thái</th>
                                <th width="120px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $item)
                                <tr>
                                    <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                    <td>{{ count($products) - $loop->index }}</td>
                                    <td>
                                        @if($item->image)
                                        <img src="{{ $item->image }}" id="image" class="img-thumbnail" width="90px" height="60px">
                                        @else
                                        <img src="{{ asset('backend/img/placeholder.png')}}" id="image" class="img-thumbnail" width="90px" height="60px">
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->name}}<br>
                                        <a href="{{route('home.product_single', $item->slug)}}" target="_blank">
                                            <i class="far fa-hand-point-right"></i> {{route('home.product_single', $item->slug)}}</a>
                                    </td>
                                    <td>{{ $item->Author->name }}</td>
                                    <td>
                                        @if(count($item->Category))
                                            @foreach ($item->Category as $cate)
                                                <span class="badge badge-info">{{$cate->name}}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge badge-success">Hiển thị</span>
                                        @endif
                                        @if ($item->status == 2)
                                            <span class="badge badge-warning">Chờ duyệt</span>
                                        @endif
                                        @if ($item->status == 3)
                                            <span class="badge badge-danger">Thùng rác</span>
                                        @endif

                                        @if ($item->hot == 1)
                                            <br><span class="badge badge-success">Nổi bật</span>
                                        @endif
                                        @if ($item->sale == 1)
                                            <br><span class="badge badge-warning">Giảm giá</span>
                                        @endif
                                        @if ($item->best_seller == 1)
                                            <br><span class="badge badge-secondary">Bán chạy</span>
                                        @endif
                                        @if ($item->bonus == 1)
                                            <br><span class="badge badge-dark">SP khuyến mãi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('products.edit', $item->id ) }}" title="Sửa" class="btn btn-sm btn-info btn-edit">
                                            <i class="fas fa-pencil-alt"></i> Sửa
                                        </a>
                                       
                                        <a href="{{route('products.moveToTrash', $item->id ) }}" title="Xóa" class="btn btn-sm btn-danger btn-destroy">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="btnAdd">
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc chắn xóa không ?')"><i class="fa fa-trash-o"></i> Xóa mục
                        đã chọn
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('page_css')
<style>
#example1 > tbody > tr > td {
     vertical-align: middle;
}
</style>
@endsection

@section('page_scripts')
<script type="text/javascript">
    $(function () {
        $('#reservation').daterangepicker({
            "autoApply": true,
            "autoUpdateInput": false,
            locale: {
            format: 'DD/MM/YYYY'
            }
        })
        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
    });
    $(document).ready(function(){
        $("#btn-submit-search").click(function(){     
            console.log("dfgdf")   
            $("#product-search").submit();
        });

        const images = document.querySelectorAll("#image")
        images.forEach(img => {
            img.addEventListener("error", function handleError() {
                img.src = "{!! asset('backend/img/placeholder.png')!!}";
                img.onerror = null;
            });
        });
    });
  
</script>
@endsection