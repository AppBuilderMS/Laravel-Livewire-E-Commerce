<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = "coupons";
    protected $guarded = [];

    public static function scopeSearch($query,$search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhere('code', 'like', '%'.$search.'%')
            ->orWhere('type', 'like', '%'.$search.'%')
            ->orWhere('value', 'like', '%'.$search.'%')
            ->orWhere('cart_value', 'like', '%'.$search.'%');
    }
}
