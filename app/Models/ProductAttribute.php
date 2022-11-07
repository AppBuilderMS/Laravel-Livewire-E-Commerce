<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';
    protected $guarded = [];

    public function attributeValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
    public static function scopeSearch($query,$search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhere('name', 'like', '%'.$search.'%');
    }
}
