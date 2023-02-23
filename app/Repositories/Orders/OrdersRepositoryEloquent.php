<?php

namespace App\Repositories\Orders;

use App\Models\Orders;
use App\Validators\Orders\OrdersValidator;
use App\Repositories\Orders\OrdersRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class OrdersRepositoryEloquent.
 *
 * @package namespace App\Repositories\Orders;
 */
class OrdersRepositoryEloquent extends BaseRepository implements OrdersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Orders::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
