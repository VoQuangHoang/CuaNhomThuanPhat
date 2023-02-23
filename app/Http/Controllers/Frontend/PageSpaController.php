<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Spa\SpaRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Categories\CategoriesRepository;

class PageSpaController extends Controller
{
    protected $spa,$pages,$categories;

    public function __construct(SpaRepository $spa,PagesRepository $pages, CategoriesRepository $categories)
    {
        $this->spa = $spa;
        $this->pages = $pages;
        $this->categories = $categories;
        $this->pages->seoGeneral();
    }
    public function getSpaPage()
    {
        $dataSeo = $this->pages->getDataByType('spa_category');
        $this->pages->createSeo($dataSeo);
        $popularCate = $this->categories->where(['type' => 'spa_category'])->orderBy('created_at', 'desc')->get();
        $contentPage = json_decode($dataSeo->content);
        return view('frontend.pages.cate_spa', compact('popularCate', 'dataSeo','contentPage'));
    }

    public function getSpaSingle($slug){
        $cateSpa = $this->categories->getCateByType('spa_category');
        $cate = $this->categories->where('slug', $slug)->where('type', 'spa_category')->first();
        if($cate){
            $mostViewSpa = $this->spa->where('status', 1)->orderBy('view', 'desc')->take(5)->get();
            $cateBySlug = $cate->Spa()->where('status', 1)->paginate(9);
            $this->pages->createSeoCategory($cate, $cateBySlug, $type='spa_category');
            return view('frontend.pages.spa_cate', compact('cate','cateSpa', 'mostViewSpa', 'cateBySlug'));
        }
        $spa = $this->spa->where('slug', $slug)->where('status', 1)->first();
        if($spa){
            return view('frontend.pages.spa_single', compact('spa'));
        }
    }
}
