<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'name',
        'desc',
        'type',
        'value',
        'count',
        'condition',
        'status'
    ];

    public function discount($total)
    {
        if ($this->type == 2) {
            return $this->value;
        } elseif ($this->type == 1) {
            return number_format(round(($this->value / 100) * $total), 0, '','');
        } else {
            return 0;
        }
    }
}
