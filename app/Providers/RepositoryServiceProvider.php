<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use App\Repositories\Spa\SpaRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Tags\TagsRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Banks\BanksRepository;
use App\Repositories\Pages\PagesRepository;
use App\Repositories\Brands\BrandsRepository;
use App\Repositories\Orders\OrdersRepository;
use App\Repositories\BlogTag\BlogTagRepository;
use App\Repositories\Spa\SpaRepositoryEloquent;
use App\Repositories\Blog\BlogRepositoryEloquent;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Tags\TagsRepositoryEloquent;
use App\Repositories\User\UserRepositoryEloquent;
use App\Repositories\Banks\BanksRepositoryEloquent;
use App\Repositories\Pages\PagesRepositoryEloquent;
use App\Repositories\Attributes\AttributesRepository;
use App\Repositories\Brands\BrandsRepositoryEloquent;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Orders\OrdersRepositoryEloquent;
use App\Repositories\ProductTag\ProductTagRepository;
use App\Repositories\BlogTag\BlogTagRepositoryEloquent;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\Customer\CustomerRepositoryEloquent;
use App\Repositories\Products\ProductsRepositoryEloquent;
use App\Repositories\Attributes\AttributesRepositoryEloquent;
use App\Repositories\Categories\CategoriesRepositoryEloquent;
use App\Repositories\ProductReviews\ProductReviewsRepository;
use App\Repositories\ProductTag\ProductTagRepositoryEloquent;
use App\Repositories\AttributeValues\AttributeValuesRepository;
use App\Repositories\OrderDetail\OrderDetailRepositoryEloquent;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\ProductReviews\ProductReviewsRepositoryEloquent;
use App\Repositories\AttributeValues\AttributeValuesRepositoryEloquent;
use App\Repositories\ProductCategory\ProductCategoryRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(UserRepository::class, UserRepositoryEloquent::class);
        App::bind(CategoriesRepository::class, CategoriesRepositoryEloquent::class);
        App::bind(PagesRepository::class, PagesRepositoryEloquent::class);
        App::bind(BlogRepository::class, BlogRepositoryEloquent::class);
        App::bind(TagsRepository::class, TagsRepositoryEloquent::class);
        App::bind(BlogTagRepository::class, BlogTagRepositoryEloquent::class);
        App::bind(BrandsRepository::class, BrandsRepositoryEloquent::class);
        App::bind(ProductsRepository::class, ProductsRepositoryEloquent::class);
        App::bind(ProductCategoryRepository::class, ProductCategoryRepositoryEloquent::class);
        App::bind(ProductTagRepository::class, ProductTagRepositoryEloquent::class);
        App::bind(AttributesRepository::class, AttributesRepositoryEloquent::class);
        App::bind(AttributeValuesRepository::class, AttributeValuesRepositoryEloquent::class);
        App::bind(ProductReviewsRepository::class, ProductReviewsRepositoryEloquent::class);
        App::bind(OrderDetailRepository::class, OrderDetailRepositoryEloquent::class);
        App::bind(OrdersRepository::class, OrdersRepositoryEloquent::class);
        App::bind(BanksRepository::class, BanksRepositoryEloquent::class);
        App::bind(CustomerRepository::class, CustomerRepositoryEloquent::class);
        App::bind(SpaRepository::class, SpaRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
