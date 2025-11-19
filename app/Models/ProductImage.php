<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasUlids, SoftDeletes;
    protected $fillable = ['product_id', 'path', 'is_main', 'sort_order', 'user_created', 'user_updated'];

    public function uniqueIds()
    {
        return ['public_id'];
    }

    public function getRouteKeyName()
    {
        return 'public_id';
    }

    // Product
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
