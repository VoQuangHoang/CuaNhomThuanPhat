@extends('backend.layouts.app')
@section('controller','Liên hệ')
@section('controller_route', route('users.index'))
@section('action','Xem')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-9">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" class="form-control" name="name" value="{!! old('name', $data->name) !!}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{!! old('email', $data->email) !!}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{!! old('phone', $data->phone) !!}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" class="form-control" name="title" value="{!! old('title', $data->title) !!}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <input type="text" class="form-control" name="content" value="{!! old('content', $data->content) !!}" disabled>
                        </div>
                       
                    
                    </div>

                </div>
            </div>
			
        </div>
    </form>

</div>

@stop