<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Http\Requests\EstateIndexRequest;
use App\Http\Resources\EstateResource;
use App\Models\Estate;

class EstateController extends Controller
{
    public function index(EstateIndexRequest $request)
    {
        usleep(500 * 1000);

        $query = Estate::query();

        if ($request->has('name')) {
            $query->where(function (Builder $query) use ($request) {
                $words = array_map('trim', explode(' ', $request->get('name')));

                foreach ($words as $word) {
                    $query->where('name', 'like', "%$word%");
                }
            });
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price', [
                $request->get('price_min'),
                $request->get('price_max'),
            ]);
        }

        foreach (['bedrooms', 'bathrooms', 'storeys', 'garages'] as $value) {
            if ($request->has($value)) {
                $query->where($value, $request->get($value));
            }
        }

        return EstateResource::collection($query->get());
    }

    public function getMinAndMaxPrice()
    {
        return response()->json([
            'min' => Estate::min('price'),
            'max' => Estate::max('price'),
        ]);
    }
}
