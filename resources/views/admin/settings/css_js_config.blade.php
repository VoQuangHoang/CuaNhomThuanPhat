@extends('admin.layouts.app')
@section('controller','Css Js Config')
@section('controller_route', route('admin.settings.css_js'))
@section('action','Cấu hình')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('admin.settings.css_js.post') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-sm-12">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nhập css (không cần thẻ style)</label>
                            <textarea class="form-control" name="content[css]" id="" cols="30" rows="10">{{ @$content->css }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nhập js (không cần thẻ script)</label>
                            <textarea class="form-control" name="content[js]" id="" cols="30" rows="10">{{ @$content->js }}</textarea>
                        </div>
                        
                        <div class="text-left">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>

</div>

@stop