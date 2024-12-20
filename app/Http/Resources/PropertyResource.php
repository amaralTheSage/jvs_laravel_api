<?php

namespace App\Http\Resources;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // This is meant to a) select only some specific attributes from Property (excluding created_at, etc) and b) turn the data into camelCase, to be used in the Json responses
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'propertyType' => $this->property_type,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'description' => $this->description,
            'area' => $this->area,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'carSpots' => $this->car_spots,
            'price' => $this->price,
            'rent' => $this->rent,
            'condoPrice' => $this->condo_price,
        ];
    }
}
