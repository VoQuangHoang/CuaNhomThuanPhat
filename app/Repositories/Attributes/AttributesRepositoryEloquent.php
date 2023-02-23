<?php

namespace App\Repositories\Attributes;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Attributes\AttributesRepository;
use App\Models\Attributes;
use App\Validators\Attributes\AttributesValidator;

/**
 * Class AttributesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Attributes;
 */
class AttributesRepositoryEloquent extends BaseRepository implements AttributesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attributes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
