<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductReviews;
use App\Http\Controllers\Controller;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Brands\BrandsRepository;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Http\Requests\Frontend\SendProductReviewRequest;
use App\Repositories\ProductReviews\ProductReviewsRepository;

class PageProductsController extends Controller
{
    protected $pages, $products, $categories, $product_reviews, $brands;

    public function __construct(ProductsRepository $products,PagesRepository $pages, BrandsRepository $brands,
        CategoriesRepository $categories, ProductReviewsRepository $product_reviews)
    {
        $this->products = $products;
        $this->pages = $pages;
        $this->categories = $categories;
        $this->product_reviews = $product_reviews;
        $this->brands = $brands;
        $this->pages->seoGeneral();
    }

    public function getProduct()
    {
        return view('frontend.pages.product');
    }

    public function getProductSingle($slug)
    {
        $product = $this->products->getProductBySlug($slug);
        $this->pages->createSeoProduct($product);
        $productSameCate = $this->products->productSameCategory($product, 8);
        $productPopular = $this->products->getPopularProducts(6);
        // $productReviewsLoad = $this->product_reviews->where('product_id', $product->id)->where('status', 1)->paginate(2);
        // $avgReviews = $product->Reviews->avg('star');
        return view('frontend.pages.product_single', compact('product', 'productSameCate', 'productPopular'));
    }

    public function getQuickView($slug)
    {
        $product = $this->products->getProductBySlug($slug);
        $avgReviews = $product->Reviews->avg('star');
        $responHtml = View::make('frontend.ajax.get_quick_view',compact('product','avgReviews'))->render();

        return response()->json([
            'success' => true,
            'html' => $responHtml
        ]);
    }

    public function sendReview(SendProductReviewRequest $request)
    {
        if(!Auth()->check()){
            return response()->json([
                'check' => 'login',
                'message' => 'Vui lòng đăng nhập để đánh giá sản phẩm'
            ]);
        }
        $data = $request->all();
        $data['star'] = $request->rate_value;
        $data['status'] = 1;
        $data['user_id'] = Auth()->user()->id;
        ProductReviews::create($data);
        
        return response()->json([
            'success' => true,
            'message' => "Gửi đánh giá sản phẩm thành công"
        ]);
    }

    public function getMoreReview(Request $request)
    {
        $product = $this->products->getProductBySlug($request->slug);
        $productReviews = $this->product_reviews->where('product_id', $product->id)->where('status', 1)->paginate(2);
        $responHtml = View::make('frontend.ajax.get_load_more_review',compact('productReviews'))->render();
        return response()->json([
            'html' => $responHtml,
        ]);
    }

    public function getProductCateSingle(Request $request, $slug)
    {
        try {
        $cateBySlug = $this->categories->cateBySlug('product_category', $slug);
        $productByCate = $this->products->productByCategory($request, $cateBySlug, 9);
        $this->pages->createSeoCategory($cateBySlug, $productByCate, 'product_category');
        $categories = $this->categories->getCateByType('product_category');
        $brands = $this->brands->get();
        $capacity = $this->products->distinct()->get(['capacity'])->sortBy('capacity');
        return view('frontend.pages.cate_product_single', compact('productByCate', 'cateBySlug','categories','brands', 'capacity'));
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function getProductCate()
    {
        $dataSeo = $this->pages->getDataByType('product_category');
        $this->pages->createSeo($dataSeo);
        $popularCate = $this->categories->getPopularCate();
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.cate_product', compact('popularCate', 'dataSeo','contentPage'));
    }
}
