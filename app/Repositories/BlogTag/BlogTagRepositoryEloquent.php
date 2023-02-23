<?php

namespace App\Repositories\BlogTag;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BlogTag\BlogTagRepository;
use App\Models\BlogTag;
use App\Validators\BlogTag\BlogTagValidator;

/**
 * Class BlogTagRepositoryEloquent.
 *
 * @package namespace App\Repositories\BlogTag;
 */
class BlogTagRepositoryEloquent extends BaseRepository implements BlogTagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlogTag::class;
    }

    public function getBlogTags()
    {
        $data = $this->model->all();
        
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
