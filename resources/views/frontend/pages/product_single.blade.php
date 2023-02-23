@extends('frontend.layouts.master')
@section('content')
<div class="hero-wrap hero-bread" style="background-image: url({{ asset('images/bg_1.jpg') }});">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span class="mr-2"><a
                            href="index.html">Product</a></span> <span>Product Single</span></p>
                <h1 class="mb-0 bread">Product Single</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section product-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6 mb-5 ftco-animate">
                        <div id="mainCarousel" class="carousel mb-4 w-10/12 max-w-xl mx-auto">
                            <div class="carousel__slide">
                                <div class="panzoom">
                                    <a href="{{ asset($product->image) }}" data-fancybox="gallery">
                                        <img class="panzoom__content" src="{{ asset($product->image) }}" />
                                    </a>
                                </div>
                            </div>
                            @if(!empty($product->more_image))
                                @foreach(json_decode($product->more_image) as $image)
                                    <div class="carousel__slide">
                                        <div class="panzoom">
                                            <a href="{{ asset($image->image) }}" data-fancybox="gallery">
                                                <img class="panzoom__content" src="{{ asset($image->image) }}" />
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
        
        
                        </div>
                        <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
                            <div class="carousel__slide">
                                <div class="panzoom">
                                    <img class="panzoom__content" src="{{ asset($product->image) }}" />
                                </div>
                            </div>
                            @if(!empty($product->more_image))
                                @foreach(json_decode($product->more_image) as $image)
                                    <div class="carousel__slide">
                                        <div class="panzoom">
                                            <img class="panzoom__content" src="{{ asset($image->image) }}" />
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 product-details ftco-animate">
                        <h4>{{ $product->name }}</h4>
                        <div class="product-short-desc">
                            {!! $product->short_desc!!}
                        </div>
        
                        {{-- <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <div class="select-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="" id="" class="form-control">
                                            <option value="">Small</option>
                                            <option value="">Medium</option>
                                            <option value="">Large</option>
                                            <option value="">Extra Large</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="input-group col-md-6 d-flex mb-3">
                                <span class="input-group-btn mr-2">
                                    <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                        <i class="ion-ios-remove"></i>
                                    </button>
                                </span>
                                <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1"
                                    max="100">
                                <span class="input-group-btn ml-2">
                                    <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                        <i class="ion-ios-add"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-md-12">
                                <p style="color: #000;">600 kg available</p>
                            </div>
                        </div> --}}
                        <div class="mt-5">
                            <a href="javascript::void(0)" class="btn btn-black py-2 px-4 btn-buy-now w-100" data-toggle="modal" data-target="#modalBuy">Đăng ký nhận báo giá</a>
                        </div>
                    </div>
                </div>
                <div class="product-detail-main">
                    
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item mr-2" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-toggle="pill"
                                data-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                aria-selected="true">Thông tin sản phẩm</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-2-tab" data-toggle="pill" data-target="#pills-2"
                                type="button" role="tab" aria-controls="pills-2" aria-selected="false">
                                Đánh giá ({{count($product->Reviews)}})
                            </button>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-1" role="tabpanel"
                            aria-labelledby="pills-1-tab" tabindex="0">
                            <div class="product-detail-content">
                                {!! $product->description !!}
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab"
                            tabindex="0">
                            <div class="tab-content-section mb-4">
                                <h3>Đánh giá - nhận xét từ khách hàng</h3>
                            </div>
                            <div class="tab-content-section list-comments pb-4 mb-2" id="list_product_reviews">
                                @foreach ($productReviewsLoad as $review)
                                    <div class="comment-item">
                                        <div class="avatar">
                                            @if(!empty($review->User->image))
                                            <img src="{{url($review->User->image)}}" alt="avatar">
                                            @else
                                            <img src="{{url('backend/img/default.jpg')}}" alt="avatar">
                                            @endif
                                        </div>
                                        <div class="detail">
                                            <div class="rate">
                                            @if ($review->star == 0)
                                                <div class="star star-0"></div>
                                            @elseif($review->star <= 1)
                                                <div class="star star-1"></div>
                                            @elseif($review->star > 1 && $review->star <= 2)
                                                <div class="star star-2"></div>
                                            @elseif($review->star > 2 && $review->star <= 3)
                                                <div class="star star-3"></div>
                                            @elseif($review->star > 3 && $review->star <= 4)
                                                <div class="star star-4"></div>
                                            @elseif($review->star > 4)
                                                <div class="star star-5"></div>
                                            @endif
                                            </div>
                                            <div class="user">
                                                <strong>{{$review->User->name}}</strong>
                                                <span>{{date_format($review->created_at, 'd-m-Y')}}</span>
                                            </div>
                                            <div class="content">
                                                {{ $review->content }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-content-section border-bottom mb-4">
                            <div class="text-center m-1 load-more-review">
                                <div class="load-more-action">
                                    <a id="more_reivew" data-paginate="2" data-slug="{{$product->slug}}">Xem thêm...</a>
                                </div>
                                <p class="invisible">Không còn đánh giá - nhận xét về sản phẩm</p>
                                
                            </div>
                            </div>
        
                            
                            <div class="tab-content-section">
                                <div class="desc mb-2">
                                    Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu *
                                </div>
                                <form action="{{route('home.product.post_review')}}" method="POST" class="feedback-form">
                                    <div class="form-group rate-group w-100">
                                        <strong>Đánh giá của bạn <span>*</span></strong>
                                        <input type="hidden" name="rate_value" id="rate_value" value="4">
                                        <div class="select-rate">
                                            <div class="ic-star active" data-value="1"></div>
                                            <div class="ic-star active" data-value="2"></div>
                                            <div class="ic-star active" data-value="3"></div>
                                            <div class="ic-star active" data-value="4"></div>
                                            <div class="ic-star" data-value="5"></div>
                                        </div>
                                    </div>
                                    <div class="form-group w-100 mb-3">
                                        <textarea name="content" name="rate_value" id="rate_value" cols="30" rows="5"
                                            placeholder="Nhập bình luận của bạn *" class="form-control">{!! old('content') !!}</textarea>
                                    </div>
                                    @if (Auth()->check())
                                        <div class="form-group mb-3">
                                            <input type="name" name="name" value="{{old('email', Auth()->user()->name)}}" placeholder="Họ và tên *"
                                                class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="email" name="email" value="{{old('email', Auth()->user()->email)}}" placeholder="Email *"
                                                class="form-control">
                                            <input type="hidden" name="product_id" value="{{$product->id}}" class="form-control">
                                        </div>
                                    @else
                                        <div class="form-group mb-3">
                                            <input type="name" name="name" value="{{old('email')}}" placeholder="Họ và tên *"
                                                class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="email" name="email" value="{{old('email')}}" placeholder="Email *"
                                                class="form-control">
                                            <input type="hidden" name="product_id" value="{{$product->id}}" class="form-control">
                                        </div>
                                    @endif
                                    
                                    <div class="form-submit">
                                        <input type="submit" value="Gửi đánh giá" class="btn btn-primary send_product_review">
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card product_sidebar" id="product_sidebar">
                    <div class="card-header text-white bg-primary">
                      Sản phẩm nổi bật
                    </div>
                    <ul class="list-group list-group-flush product_list_widget">
                        @foreach ($productPopular as $item)
                            <li class="list-group-item">
                                <a href="{{route('home.product_single', $item->slug)}}"><img
                                    src="{{ asset($item->image) }}" class="img-fluid" alt="Colorlib Template">
                                    <span class="product-title">{{$item->name}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- <div class="col-lg-6 mb-5 ftco-animate">
                  <a href="{{ asset($product->image) }}" class="image-popup"><img
                src="{{ asset($product->image) }}" class="img-fluid" alt="Colorlib Template"></a>
            </div> --}}
            
        </div>
    </div>
    </div>
</section>

<section class="ftco-section pt-0">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-left ftco-animate">
                {{-- <span class="subheading">Products</span> --}}
                <h4 class="mb-2 font-weight-bold text-uppercase">Sản phẩm liên quan</h4>
                {{-- <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p> --}}
            </div>
        </div>
    </div>
    <div class="container">
        <div class="product-slider owl-carousel" data-autoheight="true" data-items="4" data-desktop="4"
        data-desktop-small="4" data-tablet="2" data-mobile="2" data-nav="true" data-margintb="30"
        data-marginmb="20" data-dots="false" data-loop="true" data-autoplay="false" data-speed="500"
        data-autotime="3000">
        @foreach ($productSameCate as $item)
            <div class="owl-carousel-item product-item">
                <div class="product">
                    <a href="#" class="img-prod"><img class="img-fluid" src="{{ asset($item->image)}}" alt="Colorlib Template">
                        {{-- <span class="status">30%</span> --}}
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="{{route('home.product_single', $item->slug)}}">{{$item->name}}</a></h3>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price">
                                    <span class="price-sale">Giá: Liên hệ</span>
                                </p>
                            </div>
                        </div>
                        <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                                <a href="{{route('home.product_single', $item->slug)}}" class="view d-flex justify-content-center align-items-center ">
                                    <span>Xem thêm</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Modal -->
<form action="">
<div class="modal fade" id="modalBuy" tabindex="-1" role="dialog" aria-labelledby="modalBuyTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title text-uppercase" id="modalBuyTitle">Nhận báo giá: {{$product->name}}</span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="{{asset($product->image)}}" alt="">
                            </div>
                            <div class="col-md-6">
                                <span>{{$product->name}}</span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <span>Bạn vui lòng nhập đúng số điện thoại để chúng tôi sẽ gọi xác nhận đơn hàng trước khi giao hàng. Xin cảm ơn!</span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Tên khách hàng</label><span class="text-danger">*</span>
                          <input type="text" class="form-control" name="" id="" placeholder="Nhập tên của bạn">
                        </div>
                        <div class="form-group">
                            <label for="">Số điện thoại</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="" id="" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="" id="" placeholder=" Nhập email">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          <button type="button" class="btn btn-primary text-uppercase">Nhận báo giá</button>
        </div>
      </div>
    </div>
</div>
</form>

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
        <div class="row d-flex justify-content-center py-5">
            <div class="col-md-6">
                <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
                <span>Get e-mail updates about our latest shops and special offers</span>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control" placeholder="Enter email address">
                        <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
