<div class="cart-table-row row-header mb-5" id="nocart" style="justify-content: center;">
    <div class="table-col text-center p-5">
        <img class="mx-auto w-25 d-block" src="{{ asset('images/cart.png') }}"
            alt="">
        <i class="fas fa-exclamation-circle text-danger"></i>
        Không có sản phẩm nào trong giỏ hàng của bạn.
        <div class="load-more-review">
            <div class="load-more-action mt-4">
                <a href="{{route('home.index')}}">Trang chủ</a>
            </div>
        </div>

    </div>
</div>
