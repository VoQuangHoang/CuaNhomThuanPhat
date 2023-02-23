<div class="cart-table-row row-header">
    <div class="table-col table-col-1">
        {{ $dataCart->count() }} sản phẩm trong giỏ hàng
    </div>
    <div class="table-col table-col-2">
        Số lượng
    </div>
    {{-- <div class="table-col table-col-3">
        Điểm thưởng
    </div> --}}
    <div class="table-col table-col-4">Thành tiền</div>
    <div class="table-col table-col-5"></div>
</div>


@foreach($dataCart as $item)
    <div class="cart-table-row row-item" id="item-cart-{{ $item->id }}">
        <div class="table-col table-col-1">
            <a href="{{ route('home.product_single', $item->options->slug) }}"
                class="product">
                <div class="product-thumb">
                    <img src="{{ url('/').$item->options->image }}" alt=""
                        class="product-thumb">
                </div>
                <div class="product-detail">
                    <div class="title">
                        {{ $item->name }} {{ $item->options->product_value ? '('.$item->options->product_value.')' : ''}}
                    </div>
                    <div class="price">
                        <strong>{{ number_format($item->price, 0, 3, '.') }}
                            đ</strong>

                        @if($item->options->price_old > 0)
                        <del>{{ number_format($item->options->price_old, 0, 3, '.') }}
                            đ</del>
                        @endif
                    </div>
                </div>
            </a>
            <div id="bonus_section_{{ $item->rowId }}">
                @php
                    $getBonusProduct = getProductBonus($item->id, $item->qty);
                @endphp
                @if (count($getBonusProduct))
                <div class="cart-gift">
                    <div class="cart-gift-title">
                        <i class="fa fa-gift"
                            aria-hidden="true"></i><span> Sản phẩm tặng kèm</span>
                    </div>
                    <div class="cart-gift-list">
                        @foreach ($getBonusProduct as $bonus)
                        <div class="cart-gift-item">
                            <a href="javascript:void(0)" class="cart-gift-thumb">
                                <img src="{{ url($bonus->product->image) }}" alt="" /></a>
                            <div class="cart-gift-info">
                                <div class="info-title">
                                    <a href="javascript:void(0)"
                                    title="{{ $bonus->product->name }}">{{ $bonus->product->name }}</a>
                                </div>
                                <span>Số lượng: {{ $bonus->bonus_quantity }} khi mua từ {{ $bonus->min_required }} sản phẩm</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="table-col table-col-2">
            <div class="quantity">
                <button type="button" class="btn btn-outline-secondary">
                    <span id="minus-cart" class="minus_cart" data-id="{{ $item->id }}" data-rowid="{{ $item->rowId }}"></span>
                </button>
                <input type="number" id="quantity{{$item->id}}" class="form-control" value="{{ $item->qty }}" min="1"
                    readonly>
                <button type="button"  class="btn btn-outline-secondary">
                    <span id="plus-cart" class="plus_cart" data-id="{{ $item->id }}" data-rowid="{{ $item->rowId }}"></span>
                </button>
            </div>
        </div>
        {{-- <div class="table-col table-col-3">
            <div class="gift">{{ $item->options->pointIQ*$item->qty }} IQ</div>
        </div> --}}
        <div class="table-col table-col-4">
            <div class="amount">
                {{ number_format($item->price*$item->qty, 0, 3, '.') }} đ
            </div>
            <div class="actions">
                <div class="wishlist {{in_array($item->id, $list_pro_wishlist) ? 'active' : ''}}" id="item-wishlist-{{$item->id}}">
                    <a href="javascript:void(0)" data-id="{{$item->id}}" class="add_to_wishlist"><i class="far fa-heart"></i></a>
                </div>
                <div>
                    <a href="javascript:void(0)" data-rowid="{{ $item->rowId }}"
                        data-id="{{ $item->id }}" class="remove_item_cart">
                        <i class="far fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="table-col table-col-5">
            <div class="actions align-items-center">
                <div class="wishlist {{in_array($item->id, $list_pro_wishlist) ? 'active' : ''}}" id="item-wishlist-{{$item->id}}">
                    <a href="javascript:void(0)" data-id="{{$item->id}}" class="add_to_wishlist"><i class="far fa-heart"></i></a>
                </div>
                <div>
                    <a href="javascript:void(0)" data-rowid="{{ $item->rowId }}"
                        data-id="{{ $item->id }}" class="remove_item_cart">
                        <i class="far fa-trash"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
@endforeach

<div class="cart-table-row row-total">
    <div class="col-left">
        <div class="total-price">
            <div class="text">Tổng tiền thanh toán</div>
            <div class="price">
                {{ Cart::instance('shopping')->priceTotal(0, 3, '.') }} đ
            </div>
        </div>
    </div>
    <div class="col-right">
        <a href="{{ route('home.checkout') }}" class="make-order">Đặt Hàng</a>
    </div>
</div>