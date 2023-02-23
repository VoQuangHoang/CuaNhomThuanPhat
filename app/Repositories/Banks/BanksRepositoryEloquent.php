<?php

namespace App\Repositories\Banks;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Banks\BanksRepository;
use App\Validators\Banks\BanksValidator;

/**
 * Class BanksRepositoryEloquent.
 *
 * @package namespace App\Repositories\Banks;
 */
class BanksRepositoryEloquent extends BaseRepository implements BanksRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Banks::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
