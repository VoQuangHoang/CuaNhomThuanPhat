<?php

namespace App\Repositories\Categories;

use App\Models\Categories;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\Categories\CategoriesValidator;
use App\Repositories\Categories\CategoriesRepository;

/**
 * Class CategoriesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Categories;
 */
class CategoriesRepositoryEloquent extends BaseRepository implements CategoriesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Categories::class;
    }

    public function cateBySlug($type,$slug)
    {
        $query= $this->model->where('type',$type)->where('slug',$slug);
        if($type == 'product_category'){
            $query = $query->where('active', 1);
        }
        $data = $query->first();
        return $data;  
    }

    public function getCateByType($type)
    {
        $data = $this->model->where('type', $type)->where('active', 1)->get();
        return $data;
    }

    public function getProductCategory($take = null)
    {
        if($take){
            $data = $this->model->where('type', 'product_category')->where('parent_id', '=', 0)->take($take)->get();
        }
        else{
            $data = $this->model->where('type', 'product_category')->where('parent_id', '=', 0)->get();
        }
        return $data;
    }

    public function getCateBySlug($slug, $type)
    {
        $data = $this->model->where('slug', $slug)->where('type', $type)->first();
        return $data;
    }

    public function getPopularCatePro($take)
    {
        $query = $this->model->where('type', 'product_category')->where('parent_id', 0)
            ->where(['popular' => 1, 'active' => 1])->orderBy('created_at', 'DESC')->take($take)->get();
        return $query;
    }

    public function getChildCatePro($take)
    {
        $query = $this->model->where('type', 'product_category')->where('parent_id', '!=', 0)
            ->where('active', 1)->orderBy('popular', 'DESC')->orderBy('created_at', 'DESC')->take($take)->get();
        return $query;
    }

    public function getPopularCate()
    {
        $query = $this->model->where('type', 'product_category')->where(['popular' => 1, 'active' => 1])->orderBy('created_at', 'DESC')->get();
        return $query;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}