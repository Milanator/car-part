<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected string $model = Car::class;

    protected string $pagePath = 'car';

    protected string $routeAs = 'car';

    protected array $filterable = ['name', 'registration_number', 'is_registered'];

    protected function getListingQuery()
    {
        return $this->model::select('id', 'name', 'registration_number', 'is_registered');
    }

    protected function getModelQuery(): Builder
    {
        return $this->model::with('parts');
    }

    protected function save(Request $request, ?int $id = null): Model
    {
        dd($request->all());
        // car
        $model = $this->model::updateOrCreate(['id' => $id], $request->only(['name', 'registration_number', 'is_registered']));

        // parts

        return $model;
    }
}
