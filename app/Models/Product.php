<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function presentPrice(): string
    {
        return '$' . $this->regular_price;
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->limit(4);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function subcategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function attributeValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttributeValue::class, 'product_id');
    }

    public static function scopeSearch($query,$search)
    {
        $query->Where('name', 'like', '%'.$search.'%')
            ->orWhere('regular_price', 'like', '%'.$search.'%')
            ->orWhere('stock_status', 'like', '%'.$search.'%')
            ->orWhereHas('category', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
