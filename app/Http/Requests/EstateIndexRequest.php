<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstateIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['bail', 'nullable', 'string'],
            'bedrooms' => ['bail', 'nullable', 'integer'],
            'bathrooms' => ['bail', 'nullable', 'integer'],
            'storeys' => ['bail', 'nullable', 'integer'],
            'garages' => ['bail', 'nullable', 'integer'],
            'price_min' => ['bail', 'nullable', 'integer'],
            'price_max' => ['bail', 'nullable', 'integer'],
        ];
    }
}
