<?php

namespace App\Repositories\Blog;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Blog\BlogRepository;
use App\Models\Blog\Blog;
use App\Validators\Blog\BlogValidator;

/**
 * Class BlogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Blog;
 */
class BlogRepositoryEloquent extends BaseRepository implements BlogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Blogs::class;
    }

    public function getNewBlogs($paginate)
    {
        $data = $this->model->where(['status' => 1])
            ->orderBy('created_at','DESC')->paginate($paginate);
        return $data;
    }

    public function getMostViewBlogs($take, $paginate = false)
    {
        $query = $this->model->where('status',1)->orderBy('view','DESC')->orderBy('created_at','DESC');
        if($paginate){
            $data = $query->paginate($take);
        }else{
            $data = $query->take($take)->get();
        }
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
