<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'planID', 'plan_code');
    }
    public function planInformation(): Attribute
    {
        return Attribute::make(get: fn ($value) => json_decode($value), set: fn ($value) => json_encode($value));
    }

    public function orderInfo(): Attribute
    {
        return Attribute::make(get: fn ($value) => json_decode($value), set: fn ($value) => json_encode($value));
    }
    public function iccid(): Attribute
    {
        return Attribute::make(get: fn ($value) => json_decode($value,true), set: fn ($value) => json_encode($value));
    }

    public function total(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value / 100, set: fn ($value) => $value * 100);
    }

    public function subtotal(): Attribute
    {
        return Attribute::make(get: fn ($value) => $value / 100, set: fn ($value) => $value * 100);
    }
}
