@extends('frontend.layouts.masters')
@section('page_css')
<style type="text/css">
    .lds-ellipsis,
    .lds-ellipsis div {
      box-sizing: border-box;
    }
    .lds-ellipsis {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-ellipsis div {
      position: absolute;
      top: 33.33333px;
      width: 13.33333px;
      height: 13.33333px;
      border-radius: 50%;
      background: currentColor;
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }
    .lds-ellipsis div:nth-child(1) {
      left: 8px;
      animation: lds-ellipsis1 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(2) {
      left: 8px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(3) {
      left: 32px;
      animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(4) {
      left: 56px;
      animation: lds-ellipsis3 0.6s infinite;
    }
    @keyframes lds-ellipsis1 {
      0% {
        transform: scale(0);
      }
      100% {
        transform: scale(1);
      }
    }
    @keyframes lds-ellipsis3 {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(0);
      }
    }
    @keyframes lds-ellipsis2 {
      0% {
        transform: translate(0, 0);
      }
      100% {
        transform: translate(24px, 0);
      }
    }
    
    </style>
@endsection
@section('content')
<main class="main account">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Điểm thưởng</li>
            </ol>
        </nav>

        <div class="row">

            @include('frontend.customer.sidebar')

            <div class="col-lg-8">
                <section class="account-section account-gift">
                    <h3>Quản lý điểm thưởng</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                  <th style="width:80px">Hoạt động</th>
                                  <th style="width:60px">Điểm</th>
                                  <th style="width:80px">Tổng IQ</th>
                                  <th style="width:110px">Thời gian</th>
                                  <th>Nội dung</th>
                                  <th style="width:110px">Điểm khả dụng tại thời điểm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($log_iq))
                                    @foreach ($log_iq as $item)
                                    <tr>
                                      <td>{{$item->title}}</td>
                                      <td>{{$item->type == 0 ? '+' : '-'}}{{number_format($item->iq_number, 0, 3, '.')}}</td>
                                      <td>{{number_format($item->iq_total, 0, 3, '.')}}</td>
                                      <td>{{date_format($item->updated_at, 'd-m-Y H:i')}}</td>
                                      <td>
                                        {{$item->note}}
                                      </td>
                                      <td>{{date_format($item->updated_at, 'd-m-Y H:i')}}</td>
                                  </tr>
                                    @endforeach
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        {{-- <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div> --}}
    </div>

    
    
</main>
@stop
