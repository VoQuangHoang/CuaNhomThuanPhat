@extends('admin.layouts.app')
@section('controller','Danh mục tin tức')
@section('controller_route', route('blog-categories.index'))
@section('action','List')
@section('content')
<!-- Main content -->
<div class="container-fluid">
    @include('flash::message')
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Danh sách danh mục</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="10px"><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th width="10px">STT</th>
                                    <th width="">Tên danh mục</th>
                                    <th>Đường dẫn</th>
                                    <th width="">Thao tác</th>
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
                                            <a href="{{route('home.blog_cate', $item->slug)}}">{{route('home.blog_cate', $item->slug)}}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('blog-categories.edit', $item->id ) }}"
                                                class="btn btn-sm btn-info btn-edit" data-name="{{$item->name}}" title="Edit">
                                                <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy"
                                                data-href="{{ route('blog-categories.destroy', $item->id) }}"
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
            </div>
        </div>
    </div>
</div>

@stop
