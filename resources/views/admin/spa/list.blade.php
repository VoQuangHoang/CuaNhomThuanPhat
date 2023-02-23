@extends('admin.layouts.app')
@section('controller', 'Spa')
@section('controller_route', route('spa.index') )
@section('action','List')
@section('content')
<div class="container-fluid">
    <div class="card card-secondary card-outline">
        <div class="card-body">
            @include('flash::message')
            
            <form action="{{route('spa.postMultiDel')}}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover display w-100">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                <th width="10px">No.</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Tác giả</th>
                                <th>Trạng thái</th>
                                <th width="150">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach($data as $item)
                                    <tr>
                                        <td><input type="checkbox" name="chkItem[]" value="{{ $item->id }}"></td>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td><img src="{{ $item->image }}" class="img-responsive img-thumbnail" alt=""
                                                width="60px"></td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <span class="badge badge-info">{{$item->Category->name}}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">{{$item->Creator->name}}</span>
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success">Hiển thị</span>
                                            @else
                                                <span class="badge badge-danger">Không hiển thị</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('spa.edit',$item->id ) }}"
                                                class="btn btn-sm btn-info btn-edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy"
                                                data-href="{{ route('spa.destroy', $item->id) }}"
                                                data-toggle="modal" data-target="#confim" title="Delete">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Confirm want to delete ?')"><i class="fa fa-trash-o"></i>
                        Xóa các mục đã chọn
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
