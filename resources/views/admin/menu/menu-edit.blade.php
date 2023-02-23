@extends('admin.layouts.app')
@section('controller', 'Menu')
@section('controller_route', route('setting.menu.list') )
@section('action','Chỉnh sửa')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('flash::message')
            <div class="col-12 col-sm-5">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Link tùy chỉnh</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.menu.addMenu', $id ) }}" method="POST" class="frm_add">
                            @csrf
                        <div class="form-group">
                            <label>Tiêu đề <small>(tên trang)</small></label>
                            <input type="text" class="form-control" placeholder="Nhập tiêu đề" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Đường dẫn <small>(Chỉ coppy phần bôi đỏ)</small></label><br>
                            <label>
                                {{ url('/') }}<span style="color: red; font-weight: bold;">/gioi-thieu</span>
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">{{ url('/') }}</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Nhập đường dẫn" name="url" required>
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label>Loại trang</label>
                            <select name="class" class="form-control" id="page">
                                <option value="page-default">Trang mặc định</option>
                                <option value="page-cate">Trang danh mục</option>
                                <option value="page-spa">Trang spa</option>
                            </select>
                        </div>
                        <div class="text-left">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Thêm menu</button>
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>
            <div class="col-12 col-sm-7">
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Menu hiển thị theo thứ tự</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
        
                            <div class="col-sm-12">
                                <form action="{{ route('setting.menu.update') }}" method="POST">
                                    <input type="hidden" id="nestable-output" name="jsonMenu">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" id="token">
                                    <button class="btn btn-success" type="submit" style="display: none;">Cập nhật menu</button>
                                    <!-- <button class="btn btn-info" data-toggle="modal" data-target="#addMenu" type="button">Thêm mới</button> -->
                                </form>
                            </div>
                        
                            <div class="col-sm-12">
                                <div class="dd" id="nestable">
                                    <ol class="dd-list">
                                        @foreach ($data as $item)
                                            @if (empty($item->parent_id))
                                                <li class="dd-item" data-id="{{ $item->id }}">
                                                    <div class="dd-handle">
                                                        {{ $item->title }} (<a href="{{ url('/').$item->url }}" target="_blank"><i>{{ url('/').$item->url }}</i></a>)
                                                    </div>
                                                    <div class="button-group">
                                                        <a href="javascript:void(0);" title="Sửa" class="modalEditMenu" data-id="{{ $item->id }}"> 
                                                            <i class="fa fa-edit"></i>
                                                        </a> &nbsp; &nbsp; &nbsp;
                                                        <a class="text-danger" href="{{route('setting.menu.delete',$item->id )}}" onclick="return confirm('Bạn có chắc chắn xóa không ?')" title="Xóa"> <i class="fa fa-times"></i></a>
                                                    </div>
                                                    <?php menuChildren($data, $item->id, $item ) ?>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
        
                        <div class="modal modal__menu" id="editMenu">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Menu</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="{{route('setting.menu.postEditItem')}}" method="POST" class="frm_add">
                                        <div class="modal-body">
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            <div class="form-group">
                                                <input type="hidden" value="" id="id_menu" name="id">
                                            </div>
                                            <div class="form-group">
                                                <label>Tiêu đề</label>
                                                <input type="text" class="form-control" placeholder="Nhập tiêu đề" id="editTitle" name="title" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Url</label>
                                                <input type="text" class="form-control" id="editUrl" name="url" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        
	</div>
@stop

@section('page_scripts')
    <script>
        jQuery(document).ready(function($) {
            var updateOutput = function(e){
                var list   = e.length ? e : $(e.target),
                    output = list.data('output'),
                    url = "{{ route('setting.menu.update') }}";

                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));
                    var param = window.JSON.stringify(list.nestable('serialize'));
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token : $('#token').val(),
                            jsonMenu: param
                        },
                    }).done(function() {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công'
                        })
                    })
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };
            $('#nestable').nestable({
                group: 3,
                maxDepth : 3
            }).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });

        $('.modalEditMenu').click(function(event) {
            var id = $(this).attr("data-id");
            $.get('{{ asset('/admin/menu/edit-item/') }}/'+id, function(data) {
                if(data.status == "success"){
                    $('#editUrl').val(data.data.url);
                    $('#editTitle').val(data.data.title);
                    $('#id_menu').val(id);
                    $('#editMenu').modal('show')
                }
            });
        });
    
    </script>
@endsection