@extends('admin.layouts.app')
@section('controller','Thẻ sản phẩm')
@section('controller_route', route('product-tags.index'))
@section('action','List')
@section('content')
<!-- Main content -->
<div class="container-fluid">
    @include('flash::message')
    <div class="row">
        <div class="col-12 col-sm-4">
            <form action="{{ route('product-tags.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Thêm thẻ (tag)</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Tên thẻ</label>
                            <input type="text" class="form-control" id="name" name="name" value="{!! old('name') !!}" required>
                        </div>
    
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-sm-8">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Danh sách thẻ (tag)</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th width="10px">STT</th>
                                    <th width="">Tên thẻ</th>
                                    <th width="150px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" data-href="{{ route('product-tags.update', $item->id ) }}"
                                                class="btn btn-sm btn-info btn-edit" data-name="{{$item->name}}" title="Edit" data-toggle="modal" data-target="#editCate">
                                                <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                            </a>
                                            
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy"
                                                data-href="{{ route('product-tags.destroy', $item->id) }}"
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
                                <h4 class="modal-title">Chỉnh sửa tag</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <form action="" method="POST" id="form-edit">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Tên tag</label>
                                        <input type="text" class="form-control" id="editName" name="name" required>
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
                $('#editName').val($(this).data('name'));
            });
        });
    </script>
@endsection
