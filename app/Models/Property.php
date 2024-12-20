<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
        'property_type',
        'city',
        'neighborhood',
        'description',
        // "images",
        'area',
        'bedrooms',
        'bathrooms',
        'car_spots',
        'price',
        'rent',
        'condo_price',
    ];
}
