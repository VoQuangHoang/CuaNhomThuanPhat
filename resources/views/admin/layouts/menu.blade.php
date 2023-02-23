<li class="nav-header">TRANG QUẢN TRỊ</li>

<li class="nav-item">
    <a href="{{ route('admin.home') }}"
        class="nav-link {{ Request::segment(2) == 'home' ? 'active' : null }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Trang tổng quan
        </p>
    </a>
</li>

<!-- User -->
<li
    class="nav-item {{ in_array(Request::segment(2), ['users', 'roles','role-discount','customer']) ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ in_array(Request::segment(2), ['users', 'roles', 'role-discount','customer']) ? 'active' : null }}">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Tài khoản
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('users.index') }}"
                class="nav-link {{ Request::segment(2) == 'users' && Request::segment(3) == '' ? 'active' : null }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tài khoản quản trị</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.create') }}"
                class="nav-link {{ Request::segment(2) =='users' && Request::segment(3) == 'create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm tài khoản quản trị</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('roles.index') }}"
                class="nav-link {{ Request::segment(2) =='roles' ? 'active' : null }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Phân quyền admin</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('customer.index') }}"
                class="nav-link {{ Request::segment(2) == 'customer' ? 'active': null }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tài khoản người dùng</p>
            </a>
        </li> --}}
    </ul>
</li>

<!-- Brands -->
{{-- <li class="nav-item {{ Request::segment(2) =='brands' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) == 'brands' ? 'active' : null }}">
        <i class="nav-icon fas fa-award"></i>
        <p>
            Thương hiệu
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('brands.index') }}"
                class="nav-link {{ Request::segment(2) =='brands' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách thương hiệu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('brands.create') }}"
                class="nav-link {{ Request::segment(2) =='brands' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm thương hiệu</p>
            </a>
        </li>
    </ul>
</li> --}}

<!-- Products -->
<li class="nav-item {{ in_array( Request::segment(2),  ['product-categories', 'products', 'attributes', 'product-tags']) ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ in_array( Request::segment(2),  ['product-categories', 'products', 'attributes', 'product-tags']) ? 'active' : null }}">
        <i class="nav-icon fab fa-product-hunt"></i>
        <p>
            Sản phẩm
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('product-categories.index') }}"
                class="nav-link {{ Request::segment(2) =='product-categories' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh mục sản phẩm</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('product-categories.create') }}"
                class="nav-link {{ Request::segment(2) =='product-categories' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm danh mục</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index').'?status=1' }}"
                class="nav-link {{ Request::segment(2) =='products' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách sản phẩm</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.create') }}"
                class="nav-link {{ Request::segment(2) =='products' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm sản phẩm</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('attributes.index') }}"
                class="nav-link {{ Request::segment(2) =='attributes'  ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Thuộc tính</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('product-tags.index') }}"
                class="nav-link {{ Request::segment(2) =='product-tags' ? 'active' : null }} ">
                <i class="fas fa-tags nav-icon"></i>
                <p>Thẻ (tags)</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('products.trash') }}"
                class="nav-link {{ Request::segment(2) =='products' && Request::segment(3) =='trash' ? 'active' : null }} ">
                <i class="far fa-trash-alt nav-icon"></i>
                <p>Thùng rác</p>
            </a>
        </li>
    </ul>
</li>

<!-- Coupons -->
{{-- <li class="nav-item {{ Request::segment(2) =='coupons' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) =='coupons' ? 'active' : null }}">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p>
            Mã khuyến mãi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('coupons.index') }}"
                class="nav-link {{ Request::segment(2) =='coupons' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách mã</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('coupons.create') }}"
                class="nav-link {{ Request::segment(2) =='coupons' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm mới mã</p>
            </a>
        </li>
    </ul>
</li> --}}

<!-- Blog -->
{{-- <li class="nav-item {{ Request::segment(2) =='blog-categories' || Request::segment(2) =='blogs' || Request::segment(2) =='blog-tags' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) =='blog-categories' || Request::segment(2) =='blogs' || Request::segment(2) =='blog-tag' ? 'active' : null }}">
        <i class="nav-icon far fa-newspaper"></i>
        <p>
            Tin tức
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('blog-categories.index') }}"
                class="nav-link {{ Request::segment(2) =='blog-categories' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh mục tin tức</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('blog-categories.create') }}"
                class="nav-link {{ Request::segment(2) =='blog-categories' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm mới danh mục</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('blogs.index') }}"
                class="nav-link {{ Request::segment(2) =='blogs' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách tin tức</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('blogs.create') }}"
                class="nav-link {{ Request::segment(2) =='blogs' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm mới tin tức</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('blog-tags.index') }}"
                class="nav-link {{ Request::segment(2) =='blog-tags' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="fas fa-tags nav-icon"></i>
                <p>Thẻ (tags)</p>
            </a>
        </li>
    </ul>
</li> --}}

<!-- Spa -->
{{-- <li class="nav-item {{ Request::segment(2) =='spa-categories' || Request::segment(2) =='spa' || Request::segment(2) =='spa-tags' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) =='spa-categories' || Request::segment(2) =='spa' || Request::segment(2) =='spa-tag' ? 'active' : null }}">
        <i class="nav-icon fas fa-spa"></i>
        <p>
            Spa
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('spa-categories.index') }}"
                class="nav-link {{ Request::segment(2) =='spa-categories' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh mục spa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('spa-categories.create') }}"
                class="nav-link {{ Request::segment(2) =='spa-categories' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm mới danh mục</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('spa.index') }}"
                class="nav-link {{ Request::segment(2) =='spa' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách spa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('spa.create') }}"
                class="nav-link {{ Request::segment(2) =='spa' && Request::segment(3) =='create' ? 'active' : null }} ">
                <i class="fas fa-plus-circle nav-icon"></i>
                <p>Thêm mới spa</p>
            </a>
        </li>
    </ul>
</li> --}}

<!-- Affiliate -->
{{-- <li class="nav-item {{ Request::segment(2) =='affiliate' || Request::segment(3) == 'affiliate' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) =='affiliate' || Request::segment(3) == 'affiliate' ? 'active' : null }}">
        <i class="nav-icon fas fa-percent"></i>
        <p>
            Affiliate
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.affiliate.list') }}"
                class="nav-link {{ Request::segment(2) =='affiliate' && Request::segment(3) =='' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách chiết khấu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.affiliate.list_request') }}"
                class="nav-link {{ Request::segment(2) =='affiliate' && Request::segment(3) =='list_request' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách yêu cầu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.affiliate') }}"
                class="nav-link {{ Request::segment(3) =='affiliate' ? 'active' : null }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Chiết khấu affiliate</p>
            </a>
        </li>
    </ul>
</li> --}}

<!-- PAGES -->

<li class="nav-item">
    <a href="{{ route('pages.list') }}"
        class="nav-link {{ Request::segment(2) == 'pages' ? 'active' : null }}">
        <i class="nav-icon fas fa-pager"></i>
        <p>
            Các trang đơn
        </p>
    </a>
</li>

<!-- MENUS -->

<li class="nav-item">
    <a href="{{ route('setting.menu.list') }}"
        class="nav-link {{ Request::segment(2) =='menu' ? 'active' : null }} ">
        <i class="nav-icon fas fa-bars"></i>
        <p>Menu</p>
    </a>
</li>

<!-- Contact -->

<li class="nav-item">
    <a href="{{ route('contacts.index') }}"
        class="nav-link {{ Request::segment(2) == 'contact' ? 'active' : null }}">
        <i class="nav-icon fas fa-address-book"></i>
        <?php $number = \App\Models\Contacts::where('status', 0)->get()->count(); ?>
        <p>
            Liên hệ
            <span class="badge badge-pill badge-warning right">{{ $number }}</span>
        </p>
    </a>
</li>

<!-- Banks -->

{{-- <li class="nav-item">
    <a href="{{ route('banks.index') }}"
        class="nav-link {{ Request::segment(2) =='banks' ? 'active' : null }}">
        <i class="fas fa-university nav-icon"></i>
        <p>Tài khoản ngân hàng</p>
    </a>
</li> --}}

<!-- Order -->

{{-- <li class="nav-item">
    <a href="{{ route('admin.order.list') }}"
        class="nav-link {{ Request::segment(2) =='order' ? 'active' : null }} ">
        <i class="nav-icon fas fa-dolly-flatbed"></i>
        @php $number1 = \App\Models\Orders::where('status',1)->get()->count(); @endphp
        <p>
            Đơn hàng
            <span class="badge badge-pill badge-warning right">{{ $number1 }}</span>
        </p>
    </a>
</li> --}}

<!-- SETTING -->
<li class="nav-header">CÀI ĐẶT HỆ THỐNG</li>

<li
    class="nav-item {{ Request::segment(3) =='general' || Request::segment(3) =='store-viettelpost' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(3)  == 'general' || Request::segment(3) =='store-viettelpost' ? 'active' : null }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>
            Cài đăt
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.settings.general') }}"
                class="nav-link {{ Request::segment(3) == 'general' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Cài đặt chung</p>
            </a>
        </li>
    </ul>
    {{-- <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.settings.viettel_post') }}"
                class="nav-link {{ Request::segment(3) == 'store-viettelpost' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Cấu hình ViettelPost</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('payments.index').'?type=vnpay' }}"
                class="nav-link {{ Request::segment(3) == 'payments' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Cấu hình VNPAY</p>
            </a>
        </li>
    </ul> --}}
</li>

{{-- <li
    class="nav-item {{ Request::segment(2) == 'payments' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(2) =='payments' ? 'active' : null }}">
        <i class="nav-icon fas fa-dollar-sign"></i>
        <p>
            VNPAY
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('payments.index').'?type=vnpay' }}"
                class="nav-link {{ Request::segment(2) == 'payments' && Request::segment(3) == '' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Cấu hình VNPAY</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('payments.log_vnpay') }}"
                class="nav-link {{ Request::segment(2) == 'payments' && Request::segment(3) =='log-vnpay' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Lịch sử giao dịch VNPAY</p>
            </a>
        </li>
    </ul>
</li> --}}

<li
    class="nav-item {{ Request::segment(3) =='css-js-config' || Request::segment(3) == 'mail-config' ? 'menu-open' : null }}">
    <a href="#" class="nav-link {{ Request::segment(3) =='css-js-config' || Request::segment(3) == 'mail-config' ? 'active' : null }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Dev config
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.settings.css_js') }}"
                class="nav-link {{ Request::segment(3) =='css-js-config' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Css,js</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.mail_config') }}"
                class="nav-link {{ Request::segment(3) =='mail-config' ? 'active' : null }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>Mail</p>
            </a>
        </li>
    </ul>
</li>

