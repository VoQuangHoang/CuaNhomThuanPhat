<?php

namespace App\Repositories\Tags;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Tags\TagsRepository;
use App\Models\Tags;
use App\Validators\Tags\TagsValidator;

/**
 * Class TagsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Tags;
 */
class TagsRepositoryEloquent extends BaseRepository implements TagsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tags::class;
    }

    public function getTagsByType($type)
    {
        $data = $this->model->where('type', $type)->get();
        return $data;
    }

    public function getTagsBySlug($slug, $type)
    {
        $data = $this->model->where('slug', $slug)->where('type', $type)->first();
        return $data;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
