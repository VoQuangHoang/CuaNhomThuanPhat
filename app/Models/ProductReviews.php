<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';

    protected $fillable = [
        'product_id',
        'name',
        'content',
        'star',
        'status',
        'user_id'
    ];

    public function User()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    public function Product()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_id');
    }
}
