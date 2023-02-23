
<div class="col-left">
    <div id="mainCarousel1" class="carousel mb-4 w-10/12 max-w-xl mx-auto">
        <div class="carousel__slide">
            <div class="panzoom">
                <a href="{{asset($product->image)}}" data-fancybox="gallery">
                    <img class="panzoom__content"
                        src="{{asset($product->image)}}" />
                </a>
            </div>
        </div>
        @if(!empty($product->more_image))
            @foreach (json_decode($product->more_image) as $image)
            <div class="carousel__slide">
                <div class="panzoom">
                    <a href="{{asset($image->image)}}" data-fancybox="gallery">
                        <img class="panzoom__content"
                            src="{{asset($image->image)}}" />
                    </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div id="thumbCarousel1" class="carousel max-w-xl mx-auto">
        <div class="carousel__slide">
            <div class="panzoom">
                <img class="panzoom__content" src="{{asset($product->image)}}" />
            </div>
        </div>
        @if(!empty($product->more_image))
            @foreach (json_decode($product->more_image) as $image)
            <div class="carousel__slide">
                <div class="panzoom">
                    <img class="panzoom__content" src="{{asset($image->image)}}" />
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<div class="col-right product-detail p-0">
    <div class="product-title">{{$product->name}}</div>
    <div class="product-info d-flex align-items-center">
        <div class="price-box d-flex align-items-center">
                @if ($product->price_sale > 0)
                    <div class="main-price me-3">{{number_format($product->price_sale, 0,3,'.')}} ₫</div>
                    <div class="old-price">
                        <del>{{number_format($product->price, 0,3,'.')}} ₫</del>
                    </div>
                @else
                    <div class="main-price me-3">{{number_format($product->price, 0,3,'.')}} ₫</div>
                @endif
        </div>
        @if ($product->instock == 1)
                <div class="product-status">
                    Còn hàng
                </div>
            @else
                <div class="product-status">
                    Hết hàng
                </div>
            @endif
    </div>
    <div class="product-introduce mb-0 border-0">
        <h4 class="head">Mô tả ngắn</h4>
        <div class="box-content limit-text-3 mb-3">
            {!! $product->short_desc !!}
        </div>
    </div>
    <form action="{{route('home.cart.add')}}" method="post">
    <div class="product-actions">
        <div class="inner-row d-flex justify-content-between flex-wrap">
            <div class="selection mt-3">
                @if (count($product->ProductAttributes)>0)
                    <label>{{$product->ProductAttributes[0]->AttributeValues->Attributes->name}}</label>
                    <select class="form-select rounded-0" name="product_attributes_id" required>
                        <option value="chon">Tùy chọn</option>
                        @foreach ($product->ProductAttributes as $pro_attr)
                            <option value="{{$pro_attr->id}}">{{$pro_attr->AttributeValues->value}}</option>
                        @endforeach
                    </select>
                @endif
                <div id='product_attributes_id'></div>
            </div>
            {{-- <div class="feedback">
                <label>Nhận xét từ khách hàng</label>
                <div class="stars mb-1">
                    @if(round($avgReviews, 0)>0)
                        @foreach (range(1, round($avgReviews, 0)) as $avgReview)
                                    <i class="fas fa-star"></i>
                        @endforeach
                    @endif

                    @if(round(5 - $avgReviews, 0) > 0)
                        @foreach (range(1, round(5 - $avgReviews, 0)) as $avgReview2)
                            <i class="far fa-star"></i>
                        @endforeach
                    @endif
                </div>
                <div class="total">{{count($product->Reviews)}} đánh giá</div>
            </div> --}}
        </div>
        <div class="inner-row d-flex justify-content-between flex-wrap">
            <div class="quantity">
                <input type="number" class="form-control rounded-0" name="quantity" value="1" min="1">
            </div>
            <div class="add-to-cart">
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="type" value="2">
                <a href="javascript:void(0);">
                    <img src="{{asset('/images/icon/ic-cart-white.svg')}}" alt="icon"> Thêm vào giỏ
                </a>
            </div>
            <div class="wishlist {{in_array($product->id, $list_pro_wishlist) ? 'active' : ''}}" id="item-wishlist-{{$product->id}}">
                <a href="javascript:void(0);" data-id="{{$product->id}}" class="add_to_wishlist">
                    <i class="far fa-heart"></i> Yêu thích
                </a>
            </div>
        </div>
        <div class="product-meta">
            <div class="box-info">
                SKU: <strong>{{$product->sku}}</strong> <br>
                Category:   @foreach ($product->Category as $cate)
                                <a href="#">{{$cate->name}}</a>{{$loop->index+1 < count($product->Category) ? ',' : ''}}
                            @endforeach <br>
                Tags:   @foreach ($product->Tags as $tag)
                            <a href="#">{{$tag->name}}</a>{{$loop->index+1 < count($product->Tags) ? ',' : ''}}
                        @endforeach
            </div>
        </div>
    </div>
    </form>
    
</div>
