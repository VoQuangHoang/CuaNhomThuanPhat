<?php

namespace App\Repositories\ProductReviews;

use App\Models\ProductReviews;
use App\Validators\ProductReviews\ProductReviewsValidator;
use App\Repositories\ProductReviews\ProductReviewsRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ProductReviewsRepositoryEloquent.
 *
 * @package namespace App\Repositories\ProductReviews;
 */
class ProductReviewsRepositoryEloquent extends BaseRepository implements ProductReviewsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductReviews::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
