<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use View;
use Illuminate\Http\Request;
use App\Models\ProductWishlist;
use App\Models\ProductAttributes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

use App\Repositories\Blog\BlogRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Products\ProductsRepository;
use App\Http\Requests\Frontend\AddCartProductRequest;
use App\Repositories\Categories\CategoriesRepository;

class CartController extends Controller
{
    protected $pages, $categories, $blogs, $products;

    public function __construct(PagesRepository $pages, CategoriesRepository $categories,
        BlogRepository $blogs, ProductsRepository $products)
    {
        $this->pages = $pages;
        $this->categories = $categories;
        $this->blogs = $blogs;
        $this->products = $products;
        $this->pages->seoGeneral();
    }

    public function getCartPage()
    {
        $dataSeo = $this->pages->getDataByType('home');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        $dataCart = Cart::instance('shopping')->content();
        
        return view('frontend.pages.cart', compact('dataCart', 'contentPage'));
    }

    public function getWishlistPage()
    {
        $dataSeo = $this->pages->getDataByType('wishlist');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        $dataWishlist = Cart::instance('wishlist')->content();
        if(!Auth::guard('customer')->check())
        {
            return back()->with(['toastr_error' => "Đăng nhập để xem sản phẩm yêu thích"]);
        }
        $arrayProId = Cart::instance('wishlist')->content()->pluck('id');
        $products = $this->products->whereIn('id', $arrayProId)->get();
        return view('frontend.pages.wishlist', compact('dataWishlist', 'products', 'contentPage'));
    }

    public function addWishlist(Request $request){
        if(!Auth::guard('customer')->check())
        {
            return response()->json([
                'check' => 'login',
            ]);
        }
        $user = Auth::guard('customer')->user();
        $dataProduct = $this->products->find($request->id);
        $pro_wishlist = ProductWishlist::where(['customer_id' => $user->id,'product_id' => $request->id])
            ->first();
        if(!empty($pro_wishlist)){
            foreach(Cart::instance('wishlist')->content() as $item_wishlist){
                if($item_wishlist->id == $request->id){
                    Cart::instance('wishlist')->remove($item_wishlist->rowId);
                }
            }
            ProductWishlist::destroy($pro_wishlist->id);
            return response()->json([
                'check' => 'deactive',
                'count' => Cart::instance('wishlist')->content()->count(),
            ]);
        }
        $dataCart    = [
            'id'      => $dataProduct->id,
            'name'    => $dataProduct->name,
            'qty'     => 1,
            'price'   => $dataProduct->price,
            'weight'  => 0,
        ];
        $dataWishlist = [
            'customer_id' => $user->id,
            'product_id' => $dataProduct->id,
            'type' => 'Sản phẩm yêu thích'
        ];
        ProductWishlist::create($dataWishlist);
        Cart::instance('wishlist')->add($dataCart);
        return response()->json([
            'check' => 'active',
            'count' => Cart::instance('wishlist')->content()->count(),
        ]);
    }

    public function addCart(AddCartProductRequest $request)
    {
        $product_id = $request->id;
        
        $dataProduct = $this->products->find($product_id);

        if ($request->type == 1){
            if(count($dataProduct->ProductAttributes)>0){
                return response()->json([
                    'url' => route('home.product_single', $dataProduct->slug),
                    'type' => 1,
                ]);
            }
            $dataCart    = [
                'id'      => $dataProduct->id,
                'name'    => $dataProduct->name,
                'qty'     => $request->quantity,
                'price'   => $dataProduct->price_sale > 0 ? $dataProduct->price_sale : $dataProduct->price,
                'weight'  => $dataProduct->weight,
                'options' => [
                    'image'      => $dataProduct->image,
                    'slug'       => $dataProduct->slug,
                    'sku'        => $dataProduct->sku,
                ],
            ];
        }

        if ($request->type == 2){
            if(!empty($request->product_attributes_id)){
                $attrName = $dataProduct->ProductAttributes[0]->AttributeValues->Attributes->name;
                $attrValueName = ProductAttributes::find($request->product_attributes_id)->AttributeValues->value;
                $dataCart    = [
                    'id'      => $dataProduct->id,
                    'name'    => $dataProduct->name,
                    'qty'     => $request->quantity,
                    'price'   => $dataProduct->price_sale > 0 ? $dataProduct->price_sale : $dataProduct->price,
                    'weight'  => $dataProduct->weight,
                    'options' => [
                        'image'      => $dataProduct->image,
                        'slug'       => $dataProduct->slug,
                        'sku'        => $dataProduct->sku,
                        'product_attributes_id' => $request->product_attributes_id,
                        'product_value' => $attrName .':'. $attrValueName,
                    ],
                ];
            }else{
                $dataCart    = [
                    'id'      => $dataProduct->id,
                    'name'    => $dataProduct->name,
                    'qty'     => $request->quantity,
                    'price'   => $dataProduct->price_sale > 0 ? $dataProduct->price_sale : $dataProduct->price,
                    'weight'  => $dataProduct->weight,
                    'options' => [
                        'image'      => $dataProduct->image,
                        'slug'       => $dataProduct->slug,
                        'sku'        => $dataProduct->sku,
                    ],
                ];
            }
        }
        
        Cart::instance('shopping')->add($dataCart);
        
        // if($request->type == 2){
        //     $dataCart = Cart::instance('shopping')->content();
        //     $totalPoint = getBonusPointTotal($dataCart)+getProductPointTotal($dataCart);
        //     $responHtml = View::make('frontend.ajax.get_full_cart', compact('dataCart', 'totalPoint'))->render();
        //     return response()->json([
        //         'count' => Cart::instance('shopping')->content()->count(),
        //         'type' => 2,
        //         'cart_full' => $responHtml
        //     ]);
        // }

        return response()->json([
            'count' => Cart::instance('shopping')->content()->count(),
            'type' => 2,
        ]);
    }

    public function updateCart(Request $request)
    {
        $qty = $request->qty;

        Cart::instance('shopping')->update($request->id, $qty);

        $dataCart = Cart::content();

        $dataCart = Cart::instance('shopping')->content();
        
        $totalPoint = 0;
     
        $totalPoint = getBonusPointTotal($dataCart)+getProductPointTotal($dataCart);
        
        $responHtml = View::make('frontend.ajax.get_full_cart', compact('dataCart', 'totalPoint'))->render();
        return response()->json([
            'count' => Cart::instance('shopping')->content()->count(),
            'cart_full' => $responHtml
        ]);
    }

    public function removeCart(Request $request)
    {
        Cart::instance('shopping')->remove($request->rowid);

        if(Cart::instance('shopping')->content()->count() == 0)
        {
            $responHtml = View::make('frontend.ajax.get_cart_none')->render();
            return response()->json([
                'success' => true,
                'cart_none' => $responHtml,
                'count' => Cart::instance('shopping')->content()->count(),
        ]);
        }

        return response()->json([
                'success' => true,
                'count' => Cart::instance('shopping')->content()->count(),
        ]);
    }
}
