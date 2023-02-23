@extends('admin.layouts.app')
@section('controller','Chiết khấu đối tác')
@section('controller_route', route('role-discount.index'))
@section('action','List')
@section('content')
<!-- Main content -->
<div class="container-fluid">
    @include('flash::message')
    <div class="row">
        <div class="col-12 col-sm-12">
            <form action="{{ route('role-discount.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Thêm chiết khấu <small>(theo vai trò người dùng)</small></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Vai trò</label>
                                    <input type="text" class="form-control" id="discount" name="name" value="{!! old('name') !!}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cấp bậc <small>(theo số - càng thấp càng cao)</small></label>
                                    <input type="number" class="form-control" id="level" name="level" min="0" value="{!! old('level') !!}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Chiết khấu <small>(theo %)</small></label>
                                    <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" value="{!! old('discount') !!}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Điều kiện áp dụng <small>(theo ₫)</small></label>
                                    <input type="number" class="form-control" id="condition_apply" name="condition_apply" min="0" value="{!! old('condition_apply') !!}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Số lượng mua tối thiểu <small>(mỗi sản phẩm)</small></label>
                                    <input type="number" class="form-control" id="quantity_apply" name="quantity_apply" min="0" value="{!! old('quantity_apply') !!}" required>
                                </div>
                            </div>
                        </div>
                        
                        

    
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-sm-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Danh sách</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th width="10px">STT</th>
                                    <th width="">Vai trò</th>
                                    <th>Chiết khấu (%)</th>
                                    <th>Điều kiện áp dụng</th>
                                    <th>Số lượng mua tối thiểu</th>
                                    <th>Cấp bậc</th>
                                    <th width="">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roleDiscound as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            {{$item->discount}}
                                        </td>
                                        <td>
                                            {{number_format($item->condition_apply, 0,3,'.')}} ₫
                                        </td>
                                        <td>
                                            {{$item->quantity_apply}}
                                        </td>
                                        <td>
                                            {{$item->level}}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" data-href="{{ route('role-discount.update', $item->id ) }}"
                                                class="btn btn-sm btn-info btn-edit" data-condition="{{$item->condition_apply}}" data-name="{{$item->name}}"
                                                data-discount="{{$item->discount}}" data-level="{{$item->level}}" data-quantity="{{$item->quantity_apply}}"
                                                title="Edit" data-toggle="modal" data-target="#editCate">
                                                <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy"
                                                data-href="{{ route('role-discount.destroy', $item->id) }}"
                                                data-toggle="modal" data-target="#confim" title="Delete">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal -->
        
                <div class="modal modal__menu" id="editCate">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Chỉnh sửa chiết khấu</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="" method="POST" id="form-edit">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vai trò</label>
                                        <input type="text" class="form-control" id="editName" name="name" value="{!! old('name') !!}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Chiết khấu</label>
                                        <input type="number" class="form-control" id="editDiscount" name="discount" min="0" max="100" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Điều kiện áp dụng</label>
                                        <input type="number" class="form-control" id="editCondition" name="condition_apply" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Số lượng tối thiểu <small>(mỗi sp)</small></label>
                                        <input type="number" class="form-control" id="editQuantity" name="quantity_apply" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Cấp bậc</label>
                                        <input type="number" class="form-control" id="editLevel" name="level" min="0" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-success">Lưu lại</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            </div>
        </div>
    </div>
</div>

@stop

@section('page_scripts')
    <script>
        $(function () {
            $('body').on('click', '.btn-edit', function(event) {
                var action = $(this).attr('data-href');
                $('#form-edit').attr('action', action);
                $('#editDiscount').val($(this).data('discount'));
                $('#editLevel').val($(this).data('level'));
                $('#editName').val($(this).data('name'));
                $('#editCondition').val($(this).data('condition'));
                $('#editQuantity').val($(this).data('quantity'));
            });
        });
    </script>
@endsection
