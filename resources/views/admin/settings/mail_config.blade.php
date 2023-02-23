@extends('admin.layouts.app')
@section('controller','Mail Config')
@section('controller_route', route('admin.settings.mail_config'))
@section('action','Cấu hình')
@section('content')
<!-- Main content -->
<div class="container-fluid">
    @include('flash::message')
    <div class="row">
        <div class="col-6 col-md-6 col-sm-12">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Cấu hình SMTP</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.mail_config.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Mail driver</label>
                            <input type="text" name="content[driver]" class="form-control"
                                value="{{ @$content->driver }}" placeholder="smtp">
                        </div>
                        <div class="form-group">
                            <label for="">Mail host</label>
                            <input type="text" name="content[host]" class="form-control"
                                value="{{ @$content->host }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="">Mail port</label>
                            <input type="text" name="content[port]" class="form-control"
                                value="{{ @$content->port }}" placeholder="587">
                        </div>
                        <div class="form-group">
                            <label for="">Mail encryption</label>
                            <input type="text" name="content[encryption]" class="form-control"
                                value="{{ @$content->encryption }}" placeholder="tls">
                        </div>
                        <div class="form-group">
                            <label for="">Mail username</label>
                            <input type="text" name="content[username]" autocomplete="off" class="form-control"
                                value="{{ @$content->username }}">
                        </div>
                        <div class="form-group">
                            <label for="">Mail password</label>
                            <input type="password" name="content[password]" autocomplete="off" class="form-control"
                                value="{{ @$content->password }}">
                        </div>
                        <div class="form-group">
                            <label for="">Mail name</label>
                            <input type="text" name="content[name]" autocomplete="off" class="form-control"
                                value="{{ @$content->name }}">
                        </div>

                        <div class="text-left">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-sm-12">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Kiểm tra gửi mail</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.send_mail.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Tới</label>
                            <input type="email" name="smtp_email" class="form-control" value="" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tiêu đề</label>
                            <input type="text" name="smtp_title" class="form-control" value="" placeholder="Tiêu đề" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tin nhắn</label>
                            <textarea class="form-control" rows="5" name="smtp_message" required></textarea>
                        </div>

                        <div class="text-left">
                            <button type="submit" class="btn btn-info"><i class="far fa-paper-plane"></i> Gửi mail test</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
