@extends('backend.layouts.app')
@section('controller','Nhập dữ liệu sản phẩm')
@section('controller_route', route('products.import.get'))
@section('action','Cấu hình')
@section('content')
<!-- Main content -->
<div class="container-fluid">

    @include('flash::message')
    <form action="{{ route('products.import.post') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12 col-sm-12">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                            <div class="custom-file">
                            <input type="file" name="product_file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            {{-- <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                            </div> --}}
                            </div>
                            </div>
                        <div class="text-left">
                            <button type="submit" class="btn btn-dark"><i class="fa fa-save"></i> Nhập dữ liệu</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>

</div>

@stop