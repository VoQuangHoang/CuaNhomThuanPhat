<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [ 'product_id','attribute_value_id', 'image'];

    public function Products()
    {
        return $this->hasOne(\App\Models\Products::class, 'id', 'product_id');
    }

    public function AttributeValues()
    {
        return $this->hasOne(\App\Models\AttributeValues::class, 'id', 'attribute_value_id');
    }
}
