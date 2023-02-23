@extends('frontend.master')
@section('main')
    @section('css')
        <link rel="stylesheet" href="{{ __BASE_URL__ }}/css/pages/page__thanks.css">
    @endsection

    <style>
        .confirmation__message {
            width: 500px;
            height: 300px;
            text-align: center;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px #000;
            z-index: 9;
        }


        .bs-modal.show-modal {
            background-color: rgba(0, 0, 0, 0.3);
        
        }
        .confirmation__message .confirmation__message-group .btn.btn__clos {
            position:absolute;
            top:5px;
            right:5px;
            width:25px;
            height:25px;
            background-color:#ed1c24;
            border-radius:3px;

        }
        .confirmation__message .confirmation__message-group .btn.btn__clos::after {
            content:"X";
            position:absolute;
            left:50%;
            top:50%;
            -webkit-transform:translate(-50%,-50%);
            -moz-transform:translate(-50%,-50%);
            -ms-transform:translate(-50%,-50%);
            transform:translate(-50%,-50%);
            color:#fff;
            font-weight:700;
        }

        .confirmation__message-group {
            margin-top: auto;
            margin-bottom: auto;
        }
        .successful-confirmation .successful__icon{
            background-color: rgb(6,190,4);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .successful-confirmation .successful__icon::before {
            content: '';
            width: 15px;
            height: 30px;
            border-right: 3px solid #fff;
            border-bottom: 3px solid #fff;
            border-bottom-right-radius: 3px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-65%) rotate(45deg);
        }
        .failed-confirmation .failed__icon{
            background-color: rgb(231, 4, 4);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .failed-confirmation .failed__icon::before {
            content: '';
            width: 2px;
            height: 40px;
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%) rotate(45deg);
        }

        .failed-confirmation .failed__icon .failed-line {
            background-color: #fff;
            position: absolute;
            width: 2px;
            height: 40px;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%) rotate(-45deg);
        }

        .successful__icon,
        .failed__icon  {
            margin-top: 2rem;
        }

        .successful__title,
        .failed__title {
            font-weight: 700;
            text-transform: uppercase;
            margin: 2rem 0;
        }

        .confirmation__message-content p {
            margin: 1rem 0;
        }

        .confirmation__message .btn.btn__home {
            width: 150px;
            background-color: rgb(49,145,255);
            color: #fff;
            text-decoration: none;
            height: 40px;
            line-height: 40px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 3rem;
        }
    </style>
  
    @php $auth = auth('customer')->user(); @endphp
    
    <main id="main">
        <section class="page-thanks">
            <div class="container">
                <div class="group__thanks">
                    <div class="img">
                        <img src="{{ __BASE_URL__ }}/images/icons/thanks.png" alt="thanks.png">
                    </div>
                   
                    <div class="thanks__bottom">
                        <a title="Tham quan tiếp" href="{{route('home.index')}}" class="btn btn__action">
                            Tham quan tiếp
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @if(request()->vnp_ResponseCode)
    <div class="bs-modal show-modal" >
		<div class="modal-frame">
			<div class="confirmation__message">
                @if(request()->vnp_ResponseCode ==00)
				<div class="confirmation__message-group">
					<button class="btn btn__clos"></button>
					<div class="successful-confirmation">
						<div class="successful__icon">
						</div>
					<div class="successful__title">
						<p>Giao dịch thàng công</p>
					</div>
                </div>
                <div class="confirmation__message-content">
					<p>
						Đơn hàng 
						<strong>{{request()->vnp_TxnRef}}</strong>
						đã được thanh toán qua VNpay
					</p>
					<p>
						Số tiền thanh toán 
						<strong>{{number_format(substr(request()->vnp_Amount, 0 , -2),0, '.', '.')}} VNĐ</strong>
					</p>
				</div>
                @else
                <div class="confirmation__message-group">
					<button class="btn btn__clos"></button>
					<div class="failed-confirmation">
                    <div class="failed__icon">
						<span class="failed-line"></span>
					</div>
					<div class="successful__title">
						<p>Giao dịch thất bại</p>
					</div>
                </div>
                <div class="confirmation__message-content">
					<p>
						{{getStatusOrderVnPay(request()->vnp_ResponseCode)}}
					</p>
					
				</div>

				
                @endif
				
				<!-- <a href="index.html" class="btn btn__home"> Xuất hàng</a> -->
				</div>
		
			</div>
		</div>
	</div>
    @endif
    @section('script')
    <script>
		$(document).ready(function(){
			$('.btn.btn__clos').on('click',function(){
				$('.bs-modal').removeClass('show-modal');
                window.location.href="{{url()->current()}}";
			});
			
		});
	</script>
    @endsection
@endsection