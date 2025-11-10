<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasUlids;
    protected $fillable = ['name', 'client', 'address', 'description', 'project_value', 'date_start', 'date_deadline', 'date_end'];

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
