<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brands;
use App\Models\Contacts;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Spa\SpaRepository;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Products\ProductsRepository;
use App\Http\Requests\Frontend\SendContactRequest;
use App\Repositories\Categories\CategoriesRepository;

class SinglePageController extends Controller
{
    protected $pages, $categories, $blogs, $products, $spa;

    public function __construct(PagesRepository $pages, CategoriesRepository $categories, BlogRepository $blogs, ProductsRepository $products,
        SpaRepository $spa)
    {
        $this->pages = $pages;
        $this->categories = $categories;
        $this->blogs = $blogs;
        $this->products = $products;
        $this->spa = $spa;
        $this->pages->seoGeneral();
    }
    
    public function getHome()
    {
        $dataSeo = $this->pages->getDataByType('home');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        $cateAll = $this->categories->getCateByType('product_category');
        $catePopularId = $this->categories->where(['active' => 1, 'popular' => 1])->pluck('id')->toArray();
        $listSlideArr = array();
        if(count($catePopularId)>0){
            foreach ($catePopularId as $cateId){
                $objCate = $this->products->productByCategoryId($cateId, 12);
                $cate = $this->categories->find($cateId);
                array_push($listSlideArr, ['list' => (object)$objCate, 'cate' => $cate]);
            }
        }
    
        return view('frontend.pages.home', compact('contentPage', 'dataSeo', 'cateAll', 'listSlideArr'));
    }

    public function getAbout()
    {
        $dataSeo = $this->pages->getDataByType('about');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        // dd($contentPage);
        return view('frontend.pages.about', compact('contentPage', 'dataSeo'));
    }

    public function getContact()
    {
        $dataSeo = $this->pages->getDataByType('contact');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.contact', compact('contentPage', 'dataSeo'));
    }

    public function getPrivacyPolicy()
    {
        $dataSeo = $this->pages->getDataByType('privacy_policy');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.policy', compact('contentPage', 'dataSeo'));
    }

    public function getPurchasePolicy()
    {
        $dataSeo = $this->pages->getDataByType('purchase_policy');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.policy', compact('contentPage', 'dataSeo'));
    }

    public function getTermsOfUse()
    {
        $dataSeo = $this->pages->getDataByType('terms_of_use');
        $this->pages->createSeo($dataSeo);
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.policy', compact('contentPage', 'dataSeo'));
    }

    public function getSearchPage(Request $request)
    {
        $dataSeo = $this->pages->getDataByType('search');
        $this->pages->createSeo($dataSeo);
        $query = Products::where('name','LIKE','%'.$request->k.'%')->where('status', 1);
        $data = $query->orderBy('created_at', 'DESC')->paginate(9)->appends($request->query());
        return view('frontend.pages.search', compact('data', 'dataSeo'));
     
    }

    public function sendContact(SendContactRequest $request){
        $input = $request->all();
        $input['status'] = 0;
        $input['type'] = 'Liên hệ';
        Contacts::create($input);
        event(new \App\Events\TestPush($request));
        return response()->json([
            'success' => true,
            'message' => "Gửi thông tin liên hệ thành công. Chúng tôi sẽ sớm liên hệ lại với bạn."
        ]);
    }

    public function sendNewsletter(Request $request)
    {
        $input = $request->all();
        $input['status'] = 0;
        $input['type'] = 'Đăng ký nhận bản tin';
        Contacts::create($input);
        return back()->with('success', 'Đăng ký nhận bản tin thành công');
    }

    public function mailOrder(){
        $cus = Auth::guard('customer')->user();
        $order = $cus->CustomerOrders;
        $data = \App\Models\Orders::find(39);
        return view('mail.order', compact('order', 'data'));
    }
}
