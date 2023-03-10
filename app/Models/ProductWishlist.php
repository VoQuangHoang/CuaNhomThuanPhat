<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model
{
    protected $table = 'product_wishlist';

    protected $fillable = [
        'product_id',
        'customer_id',
        'type'
    ];
}
