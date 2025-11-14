<?php

namespace App\Models;

use App\Observers\WoodObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([WoodObserver::class])]
class Wood extends Model
{
    use HasUlids, SoftDeletes;
    protected $fillable = ['name', 'description'];

    public function uniqueIds()
    {
        return ['public_id'];
    }

    public function getRouteKeyName()
    {
        return 'public_id';
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
