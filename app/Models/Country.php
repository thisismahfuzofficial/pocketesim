<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }



    public function scopeActiveCountry($query)
    {
        return $this->where('status', 'active');
    }
    public function scopeTopCountries($query)
    {
        return $this->where('featured', 1)->where('status', 'active');
    }


    public function startAt(): Attribute
    {
        return Attribute::make( get: fn () => $this->plans->map(fn ($plan) => $plan->salePrice ?? $plan->price)->min());
    }
}
