<?php

namespace App\Repositories\OrderDetail;

use App\Models\OrderDetail;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\OrderDetail\OrderDetailValidator;
use App\Repositories\OrderDetail\OrderDetailRepository;

/**
 * Class OrderDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories\OrderDetail;
 */
class OrderDetailRepositoryEloquent extends BaseRepository implements OrderDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
