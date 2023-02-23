<div class="col-lg-4">
    <section class="account-section account-overview">
        <div class="avatar">
            <img src="
            @if(Auth::guard('customer')->user()->image == null)
                {{asset('backend/images/default.jpg')}}
            @else
                {{asset('frontend/avatar/'.Auth::guard('customer')->user()->image)}}
            @endif
            " alt="avatar">
        </div>
        <div class="info">
            <span>Tài khoản của</span>
            <strong>{{ Auth::guard('customer')->user()->name}}</strong>
        </div>
        {{-- <div class="text">Bạn có <strong>{{Auth()->user()->total_pointIQ}}</strong> điểm thưởng</div> --}}
        @if (Auth::guard('customer')->user()->is_aff == 1)
            <div class="text"><strong>Đã đăng ký Affiliate</strong></div>
        @elseif((Auth::guard('customer')->user()->is_aff == 2))
            <div class="text"><strong>Chờ xét duyệt Affiliate</strong></div>
        @else
            <form action="{{route('home.affiliate.register')}}">
            <button type="submit" class="btn btn-sm register-aff mt-3">Đăng ký Dotiva Affiliate</button>
            </form>
        @endif
    </section>

    <section class="account-section account-menu" id="account-menu">
        <ul class="list list-unstyled mb-0">
            <li>
                <a href="{{route('home.customer.info')}}" class="sidebar_link">Thông tin chung</a> 
            </li>
            <li>
                <a href="{{route('home.customer.info_update')}}" class="sidebar_link">Cập nhật thông tin</a>
            </li>
            <li>
                <a href="{{route('home.customer.address')}}" class="sidebar_link">Sổ địa chỉ</a>
            </li>
            <li>
                <a href="{{route('home.customer.order')}}" class="sidebar_link">Đơn hàng của bạn</a>
            </li>
            <li>
                <a href="{{route('home.wishlist')}}" class="sidebar_link">Sản phẩm yêu thích</a>
            </li>
            <li>
                <a href="{{route('home.customer.change_pass')}}" class="sidebar_link">Thay đổi mật khẩu</a>
            </li>
            <li>
                <a href="{{route('home.customer.create')}}" class="sidebar_link">Tạo tài khoản thành viên</a>
            </li>
            <li>
                <a href="{{route('home.customer.list')}}" class="sidebar_link">Tài khoản thành viên</a>
            </li>
            <li>
                <a href="{{route('home.logout')}}">Đăng xuất</a>
            </li>
        </ul>
    </section>
</div>