<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /* The attributes that are mass assignable. */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /* The attributes that should be hidden for serialization. */
    protected $hidden = ['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'];

    /* Get the attributes that should be cast. */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    // AppSetting
    public function created_app_settings(): HasMany
    {
        return $this->hasMany(AppSetting::class, 'user_created');
    }

    public function updated_app_settings(): HasMany
    {
        return $this->hasMany(AppSetting::class, 'user_updated');
    }

    // Category
    public function created_category(): HasMany
    {
        return $this->hasMany(Category::class, 'user_created');
    }

    public function updated_category(): HasMany
    {
        return $this->hasMany(Category::class, 'user_updated');
    }

    // Product
    public function created_product(): HasMany
    {
        return $this->hasMany(Product::class, 'user_created');
    }

    public function updated_product(): HasMany
    {
        return $this->hasMany(Product::class, 'user_updated');
    }

    // Product Attribute
    public function created_product_attribute(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'user_created');
    }

    public function updated_product_attribute(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'user_updated');
    }

    // Product Image
    public function created_product_image(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'user_created');
    }

    public function updated_product_image(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'user_updated');
    }

    // Project
    public function created_project(): HasMany
    {
        return $this->hasMany(Project::class, 'user_created');
    }

    public function updated_project(): HasMany
    {
        return $this->hasMany(Project::class, 'user_updated');
    }

    // Project Order
    public function created_project_order(): HasMany
    {
        return $this->hasMany(ProjectOrder::class, 'user_created');
    }

    public function updated_project_order(): HasMany
    {
        return $this->hasMany(ProjectOrder::class, 'user_updated');
    }

    // Wood
    public function created_wood(): HasMany
    {
        return $this->hasMany(Wood::class, 'user_created');
    }

    public function updated_wood(): HasMany
    {
        return $this->hasMany(Wood::class, 'user_updated');
    }
}
