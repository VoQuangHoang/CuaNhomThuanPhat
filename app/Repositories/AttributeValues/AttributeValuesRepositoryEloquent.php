<?php

namespace App\Repositories\AttributeValues;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AttributeValues\AttributeValuesRepository;
use App\Models\AttributeValues;
use App\Validators\AttributeValues\AttributeValuesValidator;

/**
 * Class AttributeValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories\AttributeValues;
 */
class AttributeValuesRepositoryEloquent extends BaseRepository implements AttributeValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AttributeValues::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
