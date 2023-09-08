<?php

namespace App\Http\Resources;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstateResource extends JsonResource
{
    /**
     * @var Estate
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'bedrooms' => $this->resource->bedrooms,
            'bathrooms' => $this->resource->bathrooms,
            'storeys' => $this->resource->storeys,
            'garages' => $this->resource->garages,
            'updated_at' => $this->resource->updated_at->format('Y-m-d'),
        ];
    }
}
