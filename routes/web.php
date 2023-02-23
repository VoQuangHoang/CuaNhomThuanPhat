<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AffController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageSpaController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\PageBlogsController;
use App\Http\Controllers\Frontend\SinglePageController;
use App\Http\Controllers\Frontend\PageProductsController;
use App\Http\Controllers\Frontend\PageCategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Frontend'], function()
{
    Route::get('/', [SinglePageController::class, 'getHome'])->name('home.index');
    Route::get('/gioi-thieu', [SinglePageController::class, 'getAbout'])->name('home.about');
    Route::get('/lien-he', [SinglePageController::class, 'getContact'])->name('home.contact');
    Route::get('/dieu-khoan-su-dung', [SinglePageController::class, 'getTermsOfUse'])->name('home.terms_of_use');
    Route::get('/chinh-sach-mua-hang', [SinglePageController::class, 'getPurchasePolicy'])->name('home.purchase_policy');
    Route::get('/chinh-sach-bao-mat', [SinglePageController::class, 'getPrivacyPolicy'])->name('home.privacy_policy');
    Route::post('send-contact', [SinglePageController::class, 'sendContact'])->name('home.contact.post');
    Route::post('send-newsletter', [SinglePageController::class, 'sendNewsletter'])->name('home.newsletter.post');
    Route::get('tim-kiem', [SinglePageController::class, 'getSearchPage'])->name('home.search');

    // BLogs
    Route::get('/tin-tuc', [PageBlogsController::class, 'getBlog'])->name('home.blogs');
    Route::get('danh-muc-tin/{slug}', [PageBlogsController::class, 'getBlogCate'])->name('home.blog_cate');
    Route::get('tag-tin-tuc/{slug}', [PageBlogsController::class, 'getBlogTags'])->name('home.blog_tags');
    Route::get('tin-tuc/{slug}', [PageBlogsController::class, 'getBlogSingle'])->name('home.blog_single');
    Route::post('send-comment', [PageBlogsController::class, 'sendComment'])->name('home.comment.post');

    // Products
    Route::get('/san-pham', [PageProductsController::class, 'getProduct'])->name('home.product');
    Route::get('/san-pham/{slug}', [PageProductsController::class, 'getProductSingle'])->name('home.product_single');
    Route::get('danh-muc', [PageProductsController::class, 'getProductCate'])->name('home.product_cate');
    Route::get('danh-muc/{slug}', [PageProductsController::class, 'getProductCateSingle'])->name('home.product_cate_single');
    Route::post('send-product-review', [PageProductsController::class, 'sendReview'])->name('home.product.post_review');
    Route::get('load-more-product-review', [PageProductsController::class, 'getMoreReview'])->name('home.load_more_review');
    Route::get('show-quick-view-product/{slug}', [PageProductsController::class, 'getQuickView'])->name('home.show_quick_view');

    // Spa
    Route::get('spa', [PageSpaController::class, 'getSpaPage'])->name('home.spa');

    Route::get('spa/{slug}', [PageSpaController::class, 'getSpaSingle'])->name('home.spa.single');

    //Cart
    Route::get('gio-hang', [CartController::class,'getCartPage'])->name('home.cart');

    Route::post('add-cart', [CartController::class,'addCart'])->name('home.cart.add');

    Route::get('remove-cart', [CartController::class,'removeCart'])->name('home.cart.remove');

    Route::post('update-cart', [CartController::class,'updateCart'])->name('home.cart.update');

    Route::get('san-pham-yeu-thich', [CartController::class,'getWishlistPage'])->name('home.wishlist');

    //Wishlist
    Route::post('add-wishlist', [CartController::class,'addWishlist'])->name('home.wishlist.add');

    //Thanh toán
    Route::get('thanh-toan', [CheckoutController::class,'getCheckoutPage'])->name('home.checkout');

    Route::post('thanh-toan', [CheckoutController::class,'postCheckout'])->name('home.checkout.post');

    Route::get('/thanh-toan/callback', [CheckoutController::class,'getCheckoutCallback'])->name('home.checkout_callback');

    Route::get('/thanh-toan/VnPayIPN', [CheckoutController::class,'updateOrderVnpay'])->name('home.vnpayipn');

    Route::get('thanh-toan-thanh-cong', [CheckoutController::class,'successCheckout'])->name('home.checkout.success');

    Route::get('thanh-toan-that-bai', [CheckoutController::class,'errorCheckout'])->name('home.checkout.error');

    Route::get('get-shipping', [CheckoutController::class,'getShipping'])->name('home.get-shipping');

    Route::get('check-discount', [CheckoutController::class,'checkDiscount'])->name('home.check-discount');

    Route::get('check-referral', [CheckoutController::class,'checkReferral'])->name('home.check-referral');


    //Tỉnh - Quận - Huyện
    Route::get('quan-huyen', [CheckoutController::class,'getDistrict'])->name('home.checkout.getDistrict');

    Route::get('xa-phuong', [CheckoutController::class,'getWard'])->name('home.checkout.getWard');

    // Customer
    Route::get('dang-nhap', [CustomerController::class, 'getLogin'])->name('home.login');

    Route::post('post-dang-nhap', [CustomerController::class, 'postLogin'])->name('home.login.post');

    Route::get('dang-ky', [CustomerController::class, 'getRegister'])->name('home.register');

    Route::post('post-dang-ky', [CustomerController::class, 'postRegister'])->name('home.register.post');

    Route::get('dang-xuat', [CustomerController::class, 'getLogout'])->name('home.logout');

    //Forgot Password

    Route::get('test-order', [SinglePageController::class, 'mailOrder'])->name('home.mail.order');

    Route::get('quen-mat-khau', [CustomerController::class, 'getForgotPassword'])->name('home.forgot_password');

    Route::post('quen-mat-khau', [CustomerController::class, 'sendMailForgotPassword'])->name('home.forgot_password.post');

    Route::get('cap-nhat-mat-khau/{code}', [CustomerController::class, 'getUpdatePassword'])->name('home.update_password');

    Route::post('cap-nhat-mat-khau/{code}', [CustomerController::class, 'postUpdatePassword'])->name('home.update_password.post');


    Route::middleware(['check_customer'])->group(function (){
        // Account
        Route::get('tai-khoan', [CustomerController::class, 'getInformationCustomer'])->name('home.customer.info');

        // Address
        Route::get('so-dia-chi', [CustomerController::class, 'customerAddressPage'])->name('home.customer.address');

        Route::post('so-dia-chi', [CustomerController::class, 'postCustomerAddress'])->name('home.customer.address.post');

        Route::get('cap-nhat-dia-chi-mac-dinh/{address_id}', [CustomerController::class, 'setAddressDefault'])->name('home.customer.set_address_default');

        Route::get('xoa-dia-chi/{address_id}', [CustomerController::class, 'deleteAddressCustomer'])->name('home.customer.delete_address');

        Route::get('cap-nhat-dia-chi/{address_id}', [CustomerController::class, 'getUpdateAddressCustomer'])->name('home.customer.update_address');

        Route::post('cap-nhat-dia-chi/{address_id}', [CustomerController::class, 'postUpdateAddressCustomer'])->name('home.customer.update_address.post');

        Route::get('them-moi-dia-chi', [CustomerController::class, 'customerAddressAdd'])->name('home.customer.address_add');

        // Update password Customer
        Route::get('doi-mat-khau', [CustomerController::class, 'customerChangePassword'])->name('home.customer.change_pass');

        Route::post('post-doi-mat-khau', [CustomerController::class, 'postCustomerChangePassword'])->name('home.customer.postchange_pass');

        // Update info Customer
        Route::get('cap-nhat-thong-tin', [CustomerController::class, 'customerEditInfo'])->name('home.customer.info_update');

        Route::post('post-cap-nhat-thong-tin', [CustomerController::class, 'postCustomerEditInfo'])->name('home.customer.post_info_update');

        // Customer account
        Route::get('tao-tai-khoan', [CustomerController::class, 'createdCustomer'])->name('home.customer.create');

        Route::post('tao-tai-khoan', [CustomerController::class, 'postCreatedCustomer'])->name('home.customer.create.post');

        Route::get('tai-khoan-thanh-vien', [CustomerController::class, 'listCustomer'])->name('home.customer.list');

        Route::get('tai-khoan-thanh-vien/{id}', [CustomerController::class, 'detailCustomer'])->name('home.customer.detail');

        Route::put('cap-nhat-vai-tro/{id}', [CustomerController::class, 'updateRoleCustomer'])->name('home.customer.update_role');


        // Order Customer
        Route::get('don-hang-cua-ban', [CustomerController::class, 'customerOrderPage'])->name('home.customer.order');

    });

    //Affiliate


    Route::get('aff', [AffController::class, 'index'])->name('home.get.afflink');

    Route::get('aff/get', [AffController::class, 'get'])->name('home.get.affid');

    Route::get('affiliate/register', [AffController::class, 'registerAffiliate'])->name('home.affiliate.register');

    Route::middleware(['check_aff'])->group(function (){
        
        Route::get('affiliate', [AffController::class, 'getAffiliatePage'])->name('home.affiliate');

        Route::get('affiliate/request', [AffController::class, 'affiliateRequest'])->name('home.affiliate.request');

        Route::post('affiliate/post_request', [AffController::class, 'affiliatePostRequest'])->name('home.affiliate.post_request');

    });

    

    Route::get('mail', function(){
        return view('mail.forgot_password');
    });

});
