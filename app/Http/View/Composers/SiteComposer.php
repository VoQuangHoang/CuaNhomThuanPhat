<?php
 
namespace App\Http\View\Composers;
 
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
 
class SiteComposer
{
    // protected
 
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        
    }
 
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $site_info = getSettings('general');
    
        $css_js = getSettings('css-js-config');

        $menuHeader = \App\Models\Menu::where('group_id', 1)->orderBy('position', 'asc')->get();

        $menuFooter = \App\Models\Menu::where('group_id', 2)->orderBy('position', 'asc')->get();

        $menuParentProCate = \App\Models\Categories::where('parent_id', 0)->where('type', 'product_category')->where('active', 1)->get();

        $menuSpaCate = \App\Models\Categories::where('type', 'spa_category')->get();

        $menuCateFooter = \App\Models\Categories::where('popular', 1)->where('type', 'product_category')->take(8)->get();

        $list_pro_wishlist = [];

        if(Auth::guard('customer')->check()){
            $customer = Auth::guard('customer')->user();
            $pro_wishlist = \App\Models\ProductWishlist::where(['customer_id' => $customer->id])->get();
            $list_pro_wishlist = $pro_wishlist->pluck('product_id')->toArray();
        }

        view()->share(compact('site_info', 'css_js', 'menuHeader', 'menuSpaCate','list_pro_wishlist', 'menuParentProCate', 'menuFooter', 'menuCateFooter'));
        
    }
}