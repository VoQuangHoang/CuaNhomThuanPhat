<?php

namespace App\Repositories\Spa;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Spa\SpaRepository;
use App\Models\Spa;
use App\Validators\Spa\SpaValidator;

/**
 * Class SpaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Spa;
 */
class SpaRepositoryEloquent extends BaseRepository implements SpaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Spa::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
