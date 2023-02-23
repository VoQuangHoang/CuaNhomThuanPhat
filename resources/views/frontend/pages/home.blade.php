@extends('frontend.layouts.master')
{{-- @section('quickview')
    @include('frontend.layouts.quickview')
@endsection --}}
@section('content')
<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url(images/door1.jpg);">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

          <div class="col-md-12 ftco-animate text-center">
            <h1 class="mb-2">Chất lượng &amp; Tận tâm</h1>
            <h2 class="subheading mb-4">Chúng tôi cung cấp những gì tốt nhất cho căn nhà của bạn.</h2>
            <p><a href="#" class="btn btn-primary">Chi tiết</a></p>
          </div>

        </div>
      </div>
    </div>

    <div class="slider-item" style="background-image: url(images/door2.jpg);">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

          <div class="col-sm-12 ftco-animate text-center">
            <h1 class="mb-2">Sáng tạo &amp; Hiện đại</h1>
            <h2 class="subheading mb-4">Chúng tôi đem đến trải nghiệm mới cho không gian của bạn.</h2>
            <p><a href="#" class="btn btn-primary">Chi tiết</a></p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
    <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
        <div class="col-md-12 heading-section text-center ftco-animate">
            {{-- <span class="subheading">Featured Products</span> --}}
        <h3 class="mb-4 text-uppercase font-weight-bold">Dòng sản phẩm chính</h3>
        </div>
    </div>   		
    </div>
    <div class="container">
        <div class="product-slider owl-carousel" data-autoheight="true" data-items="4" data-desktop="4"
        data-desktop-small="4" data-tablet="2" data-mobile="2" data-nav="true" data-margintb="30"
        data-marginmb="20" data-dots="false" data-loop="true" data-autoplay="false" data-speed="500"
        data-autotime="3000">
        @foreach ($cateAll as $item)
        <div class="owl-carousel-item product-item">
            <div>
                <div class="product">
                    <a href="{{route('home.product_cate_single', $item->slug)}}" class="img-prod"><img class="img-fluid" src="{{ asset($item->image)}}" alt="Colorlib Template">
                        {{-- <span class="status">30%</span> --}}
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="{{route('home.product_cate_single', $item->slug)}}">{{$item->name}}</a></h3>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price">
                                    <span class="price-sale">{{count($item->Products)}} sản phẩm</span>
                                </p>
                            </div>
                        </div>
                        <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                                <a href="{{route('home.product_cate_single', $item->slug)}}" class="view d-flex justify-content-center align-items-center ">
                                    <span>Xem thêm</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
        
  </div>
</section>

{{-- <section class="ftco-section">
      <div class="container">
          <div class="row no-gutters ftco-services">
    <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
      <div class="media block-6 services mb-md-0 mb-4">
        <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
              <span class="flaticon-shipped"></span>
        </div>
        <div class="media-body">
          <h3 class="heading">Free Shipping</h3>
          <span>On order over $100</span>
        </div>
      </div>      
    </div>
    <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
      <div class="media block-6 services mb-md-0 mb-4">
        <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
              <span class="flaticon-diet"></span>
        </div>
        <div class="media-body">
          <h3 class="heading">Always Fresh</h3>
          <span>Product well package</span>
        </div>
      </div>    
    </div>
    <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
      <div class="media block-6 services mb-md-0 mb-4">
        <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
              <span class="flaticon-award"></span>
        </div>
        <div class="media-body">
          <h3 class="heading">Superior Quality</h3>
          <span>Quality Products</span>
        </div>
      </div>      
    </div>
    <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
      <div class="media block-6 services mb-md-0 mb-4">
        <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
              <span class="flaticon-customer-service"></span>
        </div>
        <div class="media-body">
          <h3 class="heading">Support</h3>
          <span>24/7 Support</span>
        </div>
      </div>      
    </div>
  </div>
      </div>
</section> --}}

  <section class="ftco-section ftco-category ftco-no-pt">
      <div class="container">
          <div class="row">
              <div class="col-md-8">
                  <div class="row">
                      <div class="col-md-6 order-md-last align-items-stretch d-flex">
                          <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex align-items-center" style="background-image: url(images/home7.jpg);">
                              <div class="text text-center">
                                  <h2>Nhôm kính Thuận Phát</h2>
                                  <p>Đem đến cho bạn những sản phẩm tốt nhất và phù hợp nhất</p>
                                  <p><a href="#" class="btn btn-primary">Xem thêm</a></p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(images/home1.jpg);">
                              <div class="text px-3 py-1">
                                  <h2 class="mb-0"><a href="#">Cửa nhôm</a></h2>
                              </div>
                          </div>
                          <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(images/home2.jpg);">
                              <div class="text px-3 py-1">
                                  <h2 class="mb-0"><a href="#">Cửa kính</a></h2>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(images/home3.jpg);">
                      <div class="text px-3 py-1">
                          <h2 class="mb-0"><a href="#">Cửa nhôm</a></h2>
                      </div>		
                  </div>
                  <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(images/home4.jpg);">
                      <div class="text px-3 py-1">
                          <h2 class="mb-0"><a href="#">Cửa kính</a></h2>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

@if (count($listSlideArr)>0)
    @foreach ($listSlideArr as $listSlide)
        @if (count($listSlide['list']) > 0)
        <section class="ftco-section pt-0">
            <div class="container">
                <div class="row justify-content-center mb-3 pb-3">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        {{-- <span class="subheading">Featured Products</span> --}}
                    <h3 class="mb-4 font-weight-bold text-uppercase">{{$listSlide['cate']->name}}</h3>
                    {{-- <p>Những sản phẩm được khách hàng quan tâm và lắp đặt nhiều nhất tại Thuận Phát</p> --}}
                    </div>
                </div>   		
            </div>
            <div class="container">
                <div class="product-slider owl-carousel" data-autoheight="true" data-items="4" data-desktop="4"
                data-desktop-small="4" data-tablet="2" data-mobile="2" data-nav="true" data-margintb="30"
                data-marginmb="20" data-dots="false" data-loop="true" data-autoplay="false" data-speed="500"
                data-autotime="3000">
                    @foreach ($listSlide['list'] as $item)
                    <div class="owl-carousel-item product-item">
                        <div>
                            <div class="product">
                                <a href="{{route('home.product_single', $item->slug)}}" class="img-prod"><img class="img-fluid" src="{{ asset($item->image)}}" alt="Colorlib Template">
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
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    @endforeach
    
@endif


  
<section class="ftco-section img" style="background-image: url(images/door3.jpg);">
  <div class="container">
        <div class="row justify-content-end about-section">
        <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
            <span class="subheading">NHÔM KÍNH THUẬN PHÁT</span>
            <h3 class="mb-4">Giới thiệu</h3>
            <div class="text-dark">
                Nhôm Kính Thuận Phát là công ty chuyên sản xuất – thi công lắp đặt nhôm kính, nhôm Xingfa, kính cường lực trên toàn quốc; với uy tín, đội ngũ chuyên nghiệp, thi công nhanh chóng & chất lượng, đặc biệt chính sách Bảo hành 12-24 tháng.
                <br>
                Hiện tại chúng tôi cung cấp đa dạng các sản phẩm về nhôm kính & cửa. Trong đó có các sản phẩm thế mạnh, cũng là các sản phẩm hiện được Phúc Đạt cung cấp lắp đặt trên toàn quốc. Bao gồm:

                Sản phẩm cửa: cửa nhôm Xingfa, cửa nhôm kính các loại, cửa kính cường lực các loại, cửa nhựa giả gỗ, cửa nhựa lõi thép.

                Sản phẩm nhôm kính: tủ bếp, cầu thang, lan can, tủ quần áo, kính cường lực, mặt dựng, vách ngăn…
            </div>
            <div class="mt-2">
                <a href="{{route('home.about')}}" class="btn btn-primary">Đọc tiếp</a>
                {{-- <h6><a href="">Xem thêm</a></h6> --}}
            </div>
            
            {{-- <span class="price">$10 <a href="#">now $5 only</a></span> --}}
        </div>
    </div>   		
  </div>
</section>

{{-- <section class="ftco-section testimony-section">
    <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
        <div class="col-md-7 heading-section ftco-animate text-center">
            <span class="subheading">Testimony</span>
        <h2 class="mb-4">Our satisfied customer says</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
        </div>
    </div>
    <div class="row ftco-animate">
        <div class="col-md-12">
        <div class="carousel-testimony owl-carousel">
            <div class="item">
            <div class="testimony-wrap p-4 pb-5">
                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                </span>
                </div>
                <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Marketing Manager</span>
                </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap p-4 pb-5">
                <div class="user-img mb-5" style="background-image: url(images/person_2.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                </span>
                </div>
                <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Interface Designer</span>
                </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap p-4 pb-5">
                <div class="user-img mb-5" style="background-image: url(images/person_3.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                </span>
                </div>
                <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">UI Designer</span>
                </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap p-4 pb-5">
                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                </span>
                </div>
                <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">Web Developer</span>
                </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap p-4 pb-5">
                <div class="user-img mb-5" style="background-image: url(images/person_1.jpg)">
                <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                </span>
                </div>
                <div class="text text-center">
                <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <p class="name">Garreth Smith</p>
                <span class="position">System Analyst</span>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section> --}}

{{-- <hr> --}}

<section class="ftco-section ftco-partner">
  <div class="container">
      <div class="row">
          <div class="col-sm ftco-animate">
              <a href="#" class="partner"><img src="images/partner-1.png" class="img-fluid" alt="Colorlib Template"></a>
          </div>
          <div class="col-sm ftco-animate">
              <a href="#" class="partner"><img src="images/partner-2.png" class="img-fluid" alt="Colorlib Template"></a>
          </div>
          <div class="col-sm ftco-animate">
              <a href="#" class="partner"><img src="images/partner-3.png" class="img-fluid" alt="Colorlib Template"></a>
          </div>
          <div class="col-sm ftco-animate">
              <a href="#" class="partner"><img src="images/partner-4.png" class="img-fluid" alt="Colorlib Template"></a>
          </div>
          <div class="col-sm ftco-animate">
              <a href="#" class="partner"><img src="images/partner-5.png" class="img-fluid" alt="Colorlib Template"></a>
          </div>
      </div>
  </div>
</section>

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
@stop

{{-- @section('page_script')
<script>
    $(document).ready(function () {
                // If absolute URL from the remote server is provided, configure the CORS
    // header on that server.
    var url = 'http://dotiva.me/test.pdf';

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

    console.log(pdfjsLib)

    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.worker.min.js';

    // Asynchronous download of PDF
    var loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
    console.log('PDF loaded');
    
    // Fetch the first page
    var pageNumber = 1;
    pdf.getPage(pageNumber).then(function(page) {
        console.log('Page loaded');
        
        var scale = 1.5;
        var viewport = page.getViewport(scale);

        // Prepare canvas using PDF page dimensions
        var canvas = document.getElementById('the-canvas');
        var context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
        canvasContext: context,
        viewport: viewport
        };
        var renderTask = page.render(renderContext);
        renderTask.promise.then(function () {
        console.log('Page rendered');
        });
    });
    }, function (reason) {
    // PDF loading error
    console.error(reason);
    });
            });
</script>
@endsection --}}