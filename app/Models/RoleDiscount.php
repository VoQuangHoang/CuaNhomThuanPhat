<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDiscount extends Model
{
    use HasFactory;

    protected $table = 'role_discount';

    protected $fillable = [
        'role_id',
        'discount',
        'level'
    ];

    public function roles()
    {
        return $this->hasOne(\Spatie\Permission\Models\Role::class, 'id', 'role_id');
    }
}
