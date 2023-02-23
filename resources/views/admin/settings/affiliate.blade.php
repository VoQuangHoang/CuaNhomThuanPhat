@extends('admin.layouts.app')
@section('controller','Chiết khấu affiliate')
@section('controller_route', route('admin.settings.affiliate'))
@section('action','Cấu hình')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('admin.settings.affiliate.post') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-sm-12">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Chiết khấu affiliate <small>(theo %)</small></label>
                                    <input type="number" class="form-control" min="0" max="100" name="content[affiliate]" value="{{ @$content->affiliate }}">
                                </div>
                                <div class="form-group">
                                    <label>Hạn mức rút tối thiểu <small>(theo đ)</small></label>
                                    <input type="number" class="form-control" min="0" name="content[limit]" value="{{ @$content->limit }}">
                                </div>
                            </div>
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