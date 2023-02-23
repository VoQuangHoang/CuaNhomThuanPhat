<?php

namespace App\Repositories\ProductTag;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductTag\ProductTagRepository;
use App\Models\ProductTag;
use App\Validators\ProductTag\ProductTagValidator;

/**
 * Class ProductTagRepositoryEloquent.
 *
 * @package namespace App\Repositories\ProductTag;
 */
class ProductTagRepositoryEloquent extends BaseRepository implements ProductTagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductTag::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
