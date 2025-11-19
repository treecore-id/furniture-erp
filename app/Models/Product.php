<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUlids, SoftDeletes;
    protected $fillable = ['category_id', 'name', 'description', 'product_code', 'unit_price', 'user_created', 'user_updated'];

    public function uniqueIds()
    {
        return ['public_id'];
    }

    public function getRouteKeyName()
    {
        return 'public_id';
    }

    // Category
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Product Attribute
    public function product_attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Product Image
    public function product_images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // User
    public function user_created(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function user_updated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_updated');
    }
}
