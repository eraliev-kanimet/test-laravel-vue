<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];
}
