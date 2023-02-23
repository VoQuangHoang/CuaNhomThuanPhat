<?php

namespace App\Repositories\ProductAttributes;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductAttributes\ProductAttributesRepository;
use App\Models\ProductAttributes;
use App\Validators\ProductAttributes\ProductAttributesValidator;

/**
 * Class ProductAttributesRepositoryEloquent.
 *
 * @package namespace App\Repositories\ProductAttributes;
 */
class ProductAttributesRepositoryEloquent extends BaseRepository implements ProductAttributesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductAttributes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
