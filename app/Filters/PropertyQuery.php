<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

function camelToSnake($string)
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
}

class PropertyQuery
{
    protected $allowedParams = [
        'name' => ['eq', 'like'],
        'type' => ['eq', 'like'],
        'property_type' => ['eq'],
        'city' => ['eq'],
        'neighborhood' => ['eq', 'like'],
        'area' => ['gt', 'lt'],
        'bedrooms' => ['gt'],
        'bathrooms' => ['gt'],
        'car_spots' => ['gt'],
        'price' => ['gt', 'lt'],
        'rent' => ['gt', 'lt'],
        'condo_price' => ['gt', 'lt'],
    ];

    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            if ($key == 'page') {
                continue;
            }

            $parts = explode('_', $key);
            if (count($parts) == 2) {
                $field = camelToSnake($parts[0]);
                $operator = $parts[1];
            }

            // If the filter is in the allowed parameters and if operator is allowed
            if (array_key_exists($field, $this->allowedParams) && in_array($operator, $this->allowedParams[$field])) {
                $this->applyFilter($query, $field, $operator, $value);
            }
        }

        return $query;
    }

    private function applyFilter(Builder $query, string $field, string $operator, $value)
    {
        $method = 'filter' . ucfirst($operator);
        // Calls the methods below
        if (method_exists($this, $method)) {
            $this->$method($query, $field, $value);
        }
    }

    // SQL QUERIES

    public function filterEq(Builder $query, string $field, $value)
    {
        if (is_array($value)) {
            $query->whereIn($field, $value);
        } else {
            $query->where($field, '=', $value);
        }
    }

    public function filterLike(Builder $query, string $field, $value)
    {
        $query->where($field, 'like', '%' . $value . '%');
    }

    public function filterGt(Builder $query, string $field, $value)
    {
        $query->where($field, '>', $value);
    }

    public function filterLt(Builder $query, string $field, $value)
    {
        $query->where($field, '<', $value);
    }
}
