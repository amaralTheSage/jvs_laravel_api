<?php

namespace App\Http\Controllers;

use App\Filters\PropertyQuery;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class PropertyController extends Controller
{



    public function index(Request $request)
    {
        // filters should be passed in following this format:
        // /api/properties?name_like=modern&city_eq=New York&price_gt=500000&area_lt=2000&bedrooms_gt=2
        // And if the field itself is in snake_case, it should be passe in as camelCase (car_spots -->> carSpots)

        $filters = $request->all();

        if ($filters) {
            $query = Property::query();

            $query = (new PropertyQuery)->applyFilters($query, $filters);

            return new PropertyCollection($query->paginate(10));
        }

        // This works like magic. It assumes theres a PropertyResource and then uses it to transform each item in the array;
        return new PropertyCollection(Property::paginate(10));
    }

    public function store(Request $request)
    {
        // Auth being done by the Sanctum middleware

        $request->merge(['type' => strtolower($request->input('type')), 'property_type' => strtolower($request->input('property_type'))]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:selling,renting',
            'property_type' => 'required|in:house,apartment,urban land,rural land',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'description' => 'required|string',
            // 'images' => 'nullable|array', // An array of images (if provided)
            // 'images.*' => 'nullable|url', // Validate each image URL if the images are an array of URLs
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'car_spots' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'rent' => 'nullable|numeric|min:0',
            'condo_price' => 'nullable|numeric|min:0'
        ]);

        $property = Property::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'property_type' => $validated['property_type'],
            'city' => $validated['city'],
            'neighborhood' => $validated['neighborhood'],
            'description' => $validated['description'],
            'area' => $validated['area'],
            //images
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'car_spots' => $validated['car_spots'],
            'price' => $validated['price'] ?? null,
            'rent' => $validated['rent'] ?? null,
            'condo_price' => $validated['condo_price'] ?? null,
        ]);

        return response()->json($property, 200);
    }

    public function show(Property $property)
    {
        return new PropertyResource($property);
    }

    public function update(Request $request, Property $property)
    {
        $request->merge(['type' => strtolower($request->input('type')), 'property_type' => strtolower($request->input('property_type'))]);

        $validated = $request->validate([
            'name' => 'string|max:255|nullable',
            'type' => 'in:selling,renting|nullable',
            'property_type' => 'in:house,apartment,urban land,rural land|nullable',
            'city' => 'string|max:255|nullable',
            'neighborhood' => 'string|max:255|nullable',
            'description' => 'string|nullable',
            // 'images' => 'nullable|array', // An array of images (if provided)
            // 'images.*' => 'nullable|url', // Validate each image URL if the images are an array of URLs
            'area' => 'numeric|min:0|nullable',
            'bedrooms' => 'integer|min:0|nullable',
            'bathrooms' => 'integer|min:0|nullable',
            'car_spots' => 'integer|min:0|nullable',
            'price' => 'nullable|numeric|min:0',
            'rent' => 'nullable|numeric|min:0',
            'condo_price' => 'nullable|numeric|min:0',
        ]);

        $updateData = collect($validated)->only([
            'name',
            'type',
            'property_type',
            'city',
            'neighborhood',
            'description',
            'area',
            'bedrooms',
            'bathrooms',
            'car_spots',
            'price',
            'rent',
            'condo_price'
        ])->toArray();

        $property->update($updateData);

        return new PropertyResource($property);
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json("Property of id '" . $property['id'] . "' and title '" . $property['name'] . "' deleted successfully");
    }
}
