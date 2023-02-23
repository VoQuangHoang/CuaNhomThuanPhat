@extends('errors::minimal')

@section('title', __('Lỗi quyền truy cập'))
@section('code', 'Lỗi quyền truy cập')
@section('message', __($exception->getMessage() ?: 'Người dùng không có vai trò phù hợp.'))
