<?php

namespace App\Repositories\Pages;

use SEO;
use SEOMeta;
use OpenGraph;
use App\Models\Pages;
use Artesaos\SEOTools\Facades\JsonLd;
use App\Validators\Pages\PagesValidator;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Repositories\Pages\PagesRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PagesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Pages;
 */
class PagesRepositoryEloquent extends BaseRepository implements PagesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pages::class;
    }

    public function getSiteInfo()
    {
        $site_info = \App\Models\Settings::where('type', 'general')->first();
        return $site_info;
    }

    public function getDataByType($type) {
        $data = $this->model->where('type', $type)->first();
        return $data;
    }

    public function seoGeneral()
    {
        $data = $this->getSiteInfo();

        if ($data) {
            $site_info = json_decode($data->content);
            OpenGraph::setUrl(\URL::current());
            OpenGraph::addProperty('locale', 'vi');
            OpenGraph::addProperty('type', 'website');
            OpenGraph::addProperty('author', 'JKS');
            SEOMeta::addKeyword($site_info->site_keyword);

            view()->share(compact('site_info'));
        }
    }

    public function createSeo($dataSeo = null)
    {
        $data = $this->getSiteInfo();

        $site_info = json_decode($data->content);
       
        if (!empty($dataSeo->meta_title)) {
            SEO::setTitle($dataSeo->meta_title);
            OpenGraph::setTitle($dataSeo->meta_title);
            TwitterCard::setTitle($dataSeo->meta_title);
            JsonLd::setTitle($dataSeo->meta_title);
        } else {
            SEO::setTitle($site_info->site_title);
            OpenGraph::setTitle($site_info->site_title);
            TwitterCard::setTitle($site_info->site_title);
            JsonLd::setTitle($site_info->site_title);
        }
        if (!empty($dataSeo->meta_description)) {
            SEOMeta::setDescription($dataSeo->meta_description);
            OpenGraph::setDescription($dataSeo->meta_description);
            JsonLd::setDescription('This is my page description');
            JsonLd::setType('Article');
        } else {
            SEOMeta::setDescription($data->site_description);
            OpenGraph::setDescription($data->site_description);
            // JsonLd::setDescription($data->site_description);
            JsonLd::setDescription('This is my page description');
            JsonLd::setType('Article');
        }

        if (!empty($dataSeo->image)) {
            OpenGraph::addImage(url('').$dataSeo->image, ['height' => 400, 'width' => 400]);
        } else {
            OpenGraph::addImage(url('').$site_info->logo, ['height' => 400, 'width' => 400]);
        }

        if (!empty($dataSeo->meta_keyword)) {
            SEOMeta::addKeyword($dataSeo->meta_keyword);
        }

        if(!empty($dataSeo->route)){
            $url = route($dataSeo->route);
            SEOMeta::setCanonical($url);
            OpenGraph::setUrl($url);
        }
    }

    public function createSeoBlog($data)
    {
        $getSiteInfo = $this->getSiteInfo();

        $site_info = json_decode($getSiteInfo->content);

        if(!empty($data)){
            $url = route('home.blog_single',[$data->slug]);
            OpenGraph::addProperty('type', 'article');
            JsonLd::setType('Article');
            SEOMeta::setCanonical($url);
            OpenGraph::setUrl($url);
        }

        if(!empty($data->meta_title) || $data->title){
            SEO::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->title);
            OpenGraph::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->title);
            JsonLd::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->title);
        }else {
            SEO::setTitle($site_info->site_title);
            OpenGraph::setTitle($site_info->site_title);
            JsonLd::setTitle($site_info->site_title);
        }
        if(!empty($data->meta_description)){
            SEOMeta::setDescription($data->meta_description);
            OpenGraph::setDescription($data->meta_description);
            JsonLd::setDescription($data->meta_description);
        }else {
            SEOMeta::setDescription($site_info->site_description);
            OpenGraph::setDescription($site_info->site_description);
            JsonLd::setDescription($site_info->site_description);
        }
        if (!empty($data->image)) {
            OpenGraph::addImage($data->image, ['height' => 400, 'width' => 400]);
        } else {
            OpenGraph::addImage($site_info->logo_share, ['height' => 400, 'width' => 400]);
        }
        if (!empty($data->meta_keyword)) {
            SEOMeta::addKeyword($data->meta_keyword);
        }
    }

    public function createSeoProduct($data)
    {
        $getSiteInfo = $this->getSiteInfo();

        $site_info = json_decode($getSiteInfo->content);

        if(!empty($data)){
            $url = route('home.product_single', $data->slug);
            OpenGraph::addProperty('type', 'product');
            JsonLd::setType('Product');
            SEOMeta::setCanonical($url);
            OpenGraph::setUrl($url);
        }

        if(!empty($data->meta_title) || !empty($data->name)){
            SEO::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->name);
            OpenGraph::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->name);
            JsonLd::setTitle(!empty($data->meta_title) ? $data->meta_title : $data->name);
        }else {
            SEO::setTitle($site_info->site_title);
            OpenGraph::setTitle($site_info->site_title);
            JsonLd::setTitle($site_info->site_title);
        }
        if(!empty($data->meta_description)){
            SEOMeta::setDescription($data->meta_description);
            OpenGraph::setDescription($data->meta_description);
            JsonLd::setDescription($data->meta_description);
        }else {
            SEOMeta::setDescription($site_info->site_description);
            OpenGraph::setDescription($site_info->site_description);
            JsonLd::setDescription($site_info->site_description);
        }
        if (!empty($data->image)) {
            OpenGraph::addImage($data->image, ['height' => 400, 'width' => 400]);
        } else {
            OpenGraph::addImage($site_info->logo_header, ['height' => 400, 'width' => 400]);
        }
        if (!empty($data->meta_keyword)) {
            SEOMeta::addKeyword($data->meta_keyword);
        }
    }

    public function createSeoCategory($dataSeo = null, $cate, $type)
    {
        $data = $this->getSiteInfo();

        $site_info = json_decode($data->content);

        if (!empty($dataSeo->meta_title) || $dataSeo->name) {
            SEO::setTitle($dataSeo->meta_title ? $dataSeo->meta_title : $dataSeo->name);
            OpenGraph::setTitle($dataSeo->meta_title ? $dataSeo->meta_title : $dataSeo->name);
            TwitterCard::setTitle($dataSeo->meta_title ? $dataSeo->meta_title : $dataSeo->name);
            JsonLd::setTitle($dataSeo->meta_title ? $dataSeo->meta_title : $dataSeo->name);
        } else {
            SEO::setTitle($site_info->site_title);
            OpenGraph::setTitle($site_info->site_title);
            TwitterCard::setTitle($site_info->site_title);
            JsonLd::setTitle($site_info->site_title);
        }
        if (!empty($dataSeo->meta_description)) {
            SEOMeta::setDescription($dataSeo->meta_description);
            OpenGraph::setDescription($dataSeo->meta_description);
            JsonLd::setDescription($dataSeo->meta_description);
        } else {
            SEOMeta::setDescription($site_info->site_description);
            OpenGraph::setDescription($site_info->site_description);
            JsonLd::setDescription($site_info->site_description);
        }

        if (!empty($dataSeo->image)) {
            OpenGraph::addImage(url('').$dataSeo->image, ['height' => 400, 'width' => 400]);
        } else {
            OpenGraph::addImage(url('').$site_info->logo, ['height' => 400, 'width' => 400]);
        }

        if (!empty($dataSeo->meta_keyword)) {
            SEOMeta::addKeyword($dataSeo->meta_keyword);
        }

        if(!empty($dataSeo)){
            if($type == 'product_category'){
                $url = route('home.product_single', $dataSeo->slug);
            }
            if($type == 'blog_category'){
                $url = route('home.blog_cate', $dataSeo->slug);
            }
            if ($type == 'spa_category') {
                $url = route('home.spa.single', $dataSeo->slug);
            }
            
            if ($cate->currentPage() == 1){
                if($cate->lastPage() > 1){
                    SEOMeta::setNext($url."?page=2");
                }
                SEOMeta::setCanonical($url);
            }
            if (\Request::get('page') > 1 && \Request::get('page') < $cate->lastPage()){
                SEOMeta::setPrev($url."?page=".(\Request::get('page')-1)."");
                SEOMeta::setNext($url."?page=".(\Request::get('page')+1)."");
                SEOMeta::setCanonical(\URL::full());
            }
            if ($cate->lastPage() == \Request::get('page')){
                SEOMeta::setPrev($url."?page=".(\Request::get('page')-1)."");
                SEOMeta::setCanonical(\URL::full());
            }
            OpenGraph::setUrl($url);
        }
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
