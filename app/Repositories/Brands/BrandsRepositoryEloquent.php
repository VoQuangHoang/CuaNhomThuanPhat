<?php

namespace App\Repositories\Brands;

use App\Models\Brands;
use Illuminate\Support\Facades\DB;
use App\Validators\Brands\BrandsValidator;
use App\Repositories\Brands\BrandsRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use \Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * Class BrandsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Brands;
 */
class BrandsRepositoryEloquent extends BaseRepository implements BrandsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Brands::class;
    }

    public function addBrand($data)
    {
        $slug = SlugService::createSlug(Brands::class, 'slug', $data['name']);
        $data['slug'] = $slug;
        $data['status'] = !empty($data['status']) ? 1 : null;
        $data['hot'] = !empty($data['hot']) ? 1 : null;
        $brand = $this->model->create($data);
        return $brand;
    }

    public function updateBrand($data, $id)
    {
        $brand = $this->model->find($id);
        if($data['name'] != $brand->name){
            $slug = SlugService::createSlug(Brands::class, 'slug', $data['name']);
            $data['slug'] = $slug;
        }
        $data['status'] = !empty($data['status']) ? 1 : null;
        $data['hot'] = !empty($data['hot']) ? 1 : null;
        $brand->update($data);
        return $brand;
    }

    public function getBrandsHot($take)
    {
        $data = $this->model->where(['hot' => 1, 'status' => 1])->take($take)->get();
        return $data;
    }

    public function getProductByBrand($request, $slug, $paginate)
    {
        $brand = $this->model->where(['slug' => $slug, 'status' => 1])->first();
        $productsQuery = \App\Models\Products::leftJoin('reviews', 'reviews.product_id' , '=', 'products.id')->select('products.*',DB::raw('round(avg(reviews.star),1) as stars'))
        ->groupBy('products.id')->where(['products.brand_id' => $brand->id]);

        if($request->filled('star')){
            $star = (int)$request->query('star');
            $productsQuery = $productsQuery->having('stars', '>', $star);
        }

        if($request->filled('price_from') && $request->query('price_to')){
            $price_from = (int)$request->query('price_from');
            $price_to = (int)$request->query('price_to');
            $productsQuery = $productsQuery->whereBetween('price', [$price_from, $price_to]);
        }

        if($request->filled('sort')){
            $sort = trim($request->query('sort'));

            $productsQuery = $productsQuery->when($sort == 'popular', function ($q) {
                return $q->having('popular', '=', 1);
            });
            
            $productsQuery = $productsQuery->when($sort == 'desc', function ($q) {
                return $q->orderBy('created_at', 'DESC');
            });

            $productsQuery = $productsQuery->when($sort == 'asc', function ($q) {
                return $q->orderBy('created_at', 'ASC');
            });

            $productsQuery = $productsQuery->when($sort == 'price_desc', function ($q) {
                return $q->orderBy('price', 'DESC');
            });
            $productsQuery = $productsQuery->when($sort == 'price_asc', function ($q) {
                return $q->orderBy('price', 'ASC');
            });
        }

        $products = $productsQuery->paginate($paginate)->appends($request->query());
        return $products;
    }

    public function getListAlphabet()
    {
        $listAphabet = [];
        foreach (range('A', 'Z') as $char) {
            array_push($listAphabet, $char);
        }
        return $listAphabet;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
