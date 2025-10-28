<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
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
        return $this->model::with('parts:id,car_id,name,serial_number');
    }

    protected function save(Request $request, ?int $id = null): Model
    {
        $model = $this->model::updateOrCreate(['id' => $id], $request->only(['name', 'registration_number', 'is_registered']));

        foreach ($request->parts as $part) {
            $part['car_id'] = $model->id;

            $partIds[] = Part::updateOrCreate(['serial_number' => $part['serial_number']], $part)->id;
        }

        // delete parts
        if (!empty($partIds)) {
            Part::whereCarId($model->id)->whereNotIn('id', $partIds)->delete();
        }

        return $model;
    }
}
