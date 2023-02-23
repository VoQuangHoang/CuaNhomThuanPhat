@extends('admin.layouts.app')
@section('controller', 'Sản phẩm đã xóa')
@section('controller_route', route('products.trash') )
@section('action','Danh sách')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
            <form action="{!! route('products.postMultiDel') !!}" method="POST">
                @csrf        
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped table-hover w-100">
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
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><img src="{{ $item->image }}" id="image" class="img-thumbnail" width="90px" height="60px">
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
                                            <br><span class="badge badge-success">Sale</span>
                                        @endif
                                        @if ($item->popular == 1)
                                            <br><span class="badge badge-success">Thịnh hành</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('products.edit', $item->id ) }}" title="Sửa" class="btn btn-sm btn-info btn-edit">
                                            <i class="far fa-edit"></i> Sửa
                                        </a>
                                        <a href="javascript:;" class="btn btn-sm btn-danger btn-destroy" 
                                            data-href="{{ route('products.destroy', $item->id) }}"
                                            data-toggle="modal" data-target="#confim">
                                            <i class="far fa-trash-alt"></i> Xóa 
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