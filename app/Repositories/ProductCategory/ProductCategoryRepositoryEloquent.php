<?php

namespace App\Repositories\ProductCategory;

use App\Models\ProductCategory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\ProductCategory\ProductCategoryValidator;
use App\Repositories\ProductCategory\ProductCategoryRepository;

/**
 * Class ProductCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\ProductCategory;
 */
class ProductCategoryRepositoryEloquent extends BaseRepository implements ProductCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductCategory::class;
    }

    public function getArrayProCate($id){
        $arrayId = $this->model->where('product_id', $id)->pluck('category_id')->toArray();
        return $arrayId;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
