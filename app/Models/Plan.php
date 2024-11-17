<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function body(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    public function Country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function currentPrice()
    {
        return $this->salePrice ? $this->salePrice : $this->price;
    }
    public function gb(): Attribute
    {
        return Attribute::make(
            get: fn() => is_numeric($this->attributes['data']) ? ceil($this->attributes['data'] / 1024) . " GB" : $this->attributes['data'],
        );
    }
    
}
