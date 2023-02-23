<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SpaController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BanksController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\BlogTagsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\ProductTagsController;
use App\Http\Controllers\Admin\RoleDiscountController;
use App\Http\Controllers\Admin\SpaCategoriesController;
use App\Http\Controllers\Admin\BlogCategoriesController;
use App\Http\Controllers\Admin\ProductCategoriesController;


Route::group(['prefix' => 'admin'], function() {
    Auth::routes(['register' => false, 'forgot' => false, 'verify' => false]);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {

    // Home admin
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');

    // Get layout
    Route::get('/get-layout', [HomeController::class, 'getLayOut'])->name('get.layout');

    Route::get('testsend', [HomeController::class, 'sendTest'])->name('get.send');


    // Resource
    Route::resource( 'contacts', ContactController::class)->except(['show', 'store', 'create', 'update']);
    // Resource
    Route::resource( 'customer', CustomerController::class);

    //Resources
    Route::resources([
        'blogs' => BlogsController::class,
        'blog-categories' => BlogCategoriesController::class,
        'blog-tags' => BlogTagsController::class,
        'products' => ProductsController::class,
        'product-categories' => ProductCategoriesController::class,
        'product-tags' => ProductTagsController::class,
        'coupons' => CouponsController::class,
        'brands' => BrandsController::class,
        'attributes' => AttributesController::class,
        'users' => UserController::class,
        'roles' => RolesController::class,
        'role-discount' => RoleDiscountController::class,
        'banks' => BanksController::class,
        'payments' => PaymentsController::class,
        'spa-categories' => SpaCategoriesController::class,
        'spa' => SpaController::class,
    ],
    [
        'except' => ['show']
    ]);

    // Multi delete
    Route::post('contacts/postMultiDel', [ContactController::class, 'postMultiDel'])->name('contacts.postMultiDel');

    Route::post('blog-categories/postMultiDel', [BlogCategoriesController::class, 'postMultiDel'])->name('posts-categories.postMultiDel');

    Route::post('blogs/postMultiDel', [BlogsController::class, 'postMultiDel'])->name('blogs.postMultiDel');

    Route::post('products/postMultiDel', [ProductsController::class,'postMultiDel'])->name('products.postMultiDel');

    Route::post('product-categories/postMultiDel', [ProductCategoriesController::class,'postMultiDel'])->name('product-categories.postMultiDel');

    Route::post('brands/postMultiDel', [BrandsController::class,'postMultiDel'])->name('brands.postMultiDel');

    Route::post('spa/postMultiDel', [SpaController::class,'postMultiDel'])->name('spa.postMultiDel');

    //Products
    Route::get('products/moveToTrash/{id}', [ProductsController::class,'moveToTrash'])->name('products.moveToTrash');

    Route::get('products/trash', [ProductsController::class,'getTrash'])->name('products.trash');

    Route::post('products/postMultiMoveTrash', [ProductsController::class,'postMultiMoveTrash'])->name('products.postMultiMoveTrash');

    //Roles
    Route::post('roles/addPermission', [RolesController::class,'addPermission'])->name('roles.addPermission');


    // Get tags
    Route::get('blogs/getTags', [BlogsController::class, 'getTags'])->name('blogs.getTags');

    Route::get('products/getTags', [ProductsController::class, 'getTags'])->name('products.getTags');

    // Menu
    Route::group(['prefix' => 'menu'], function() {
        Route::get('/', [MenuController::class, 'getGroupMenu'])->name('setting.menu.list');
        Route::get('edit/{id}', [MenuController::class, 'getEditMenu'])->name('setting.menu.edit');
        Route::post('update', [MenuController::class, 'postUpdateMenu'])->name('setting.menu.update');
        Route::get('delete/{id}', [MenuController::class, 'getDelete'])->name('setting.menu.delete');
        Route::post('add-menu/{id}', [MenuController::class, 'postAddMenu'])->name('setting.menu.addMenu');
        Route::get('edit-item/{id}', [MenuController::class, 'getEditItem'])->name('setting.menu.getEditItem');
        Route::post('edit', [MenuController::class, 'postEditItem'])->name('setting.menu.postEditItem');
    });

    // Single Page
    Route::group(['prefix' => 'pages'], function() {
        Route::get('/', [PagesController::class, 'getListPages'])->name('pages.list');
        Route::get('build', [PagesController::class, 'getBuildPages'])->name('pages.build');
        Route::post('build', [PagesController::class, 'postBuildPages'])->name('pages.build.post');
        Route::post('create', [PagesController::class, 'postCreatePages'])->name('pages.create');
    });

    // Setting
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/general', [SettingsController::class,'getGeneralConfig'])->name('admin.settings.general');
        Route::post('/general', [SettingsController::class,'postGeneralConfig'])->name('admin.settings.general.post');

        Route::get('/store-viettelpost', [SettingsController::class,'getViettelPostConfig'])->name('admin.settings.viettel_post');
        Route::post('/store-viettelpost', [SettingsController::class,'postViettelPostConfig'])->name('admin.settings.viettel_post.post');

        Route::get('/developer-config', [SettingsController::class,'getDeveloperConfig'])->name('admin.settings.developer-config');
        Route::post('/developer-config', [SettingsController::class,'postDeveloperConfig'])->name('admin.settings.developer-config.post');
        
        Route::get('/css-js-config', [SettingsController::class,'cssJsConfig'])->name('admin.settings.css_js');
        Route::post('/css-js-config', [SettingsController::class,'postCssJsConfig'])->name('admin.settings.css_js.post');

        Route::get('/mail-config', [SettingsController::class,'getMailConfig'])->name('admin.settings.mail_config');
        Route::post('/mail-config', [SettingsController::class,'postMailConfig'])->name('admin.settings.mail_config.post');
        Route::post('/send-mail-test', [SettingsController::class,'postSendTestEmail'])->name('admin.settings.send_mail.post');

        Route::get('/affiliate', [SettingsController::class,'getAffiliate'])->name('admin.settings.affiliate');
        Route::post('/affiliate', [SettingsController::class,'postAffiliate'])->name('admin.settings.affiliate.post');
    });

    Route::get('/order/vtp_select_store', [OrderController::class,'vtpSelectStore'])->name('admin.order.vtpSelectStore');
    Route::post('/order/vtp_create_bill', [OrderController::class,'vtpCreateBill'])->name('admin.order.vtpCreateBill');

    Route::get('affiliate', [AffiliateController::class,'index'])->name('admin.affiliate.list');
    Route::get('affiliate/list_request', [AffiliateController::class,'listRequest'])->name('admin.affiliate.list_request');
    Route::post('affiliate/process/{id}', [AffiliateController::class,'process'])->name('admin.affiliate.process');

    //Đơn hàng
    Route::group(['prefix' => 'order'], function() {
        Route::get('/', [OrderController::class,'getOrder'])->name('admin.order.list');
        Route::get('/{id}', [OrderController::class,'getOrderDetail'])->name('admin.order.detail');
        Route::delete('delete/{id}', [OrderController::class,'getDeleteOrder'])->name('admin.order.delete');
        Route::post('postMultiDel', [OrderController::class,'postMultiDel'])->name('admin.order.postMultiDel');
        Route::post('/{id}', [OrderController::class,'updateStatus'])->name('admin.order.updateStatus');
        
    });

    //Lịch sử giao Dịch
    Route::get('payments/log-vnpay', [PaymentsController::class,'logPaymentVnpay'])->name('payments.log_vnpay');
    Route::delete('payments/log-vnpay/{id}', [PaymentsController::class,'deleteLogPaymentVnpay'])->name('payments.log_vnpay.delete');

});