<?php

namespace App\Http\Controllers;

use App\Http\Requests\Part\SaveRequest;
use App\Models\Car;
use App\Models\Part;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PartController extends Controller
{
    protected string $model = Part::class;

    protected array $filterable = ['name', 'serial_number'];

    protected string $formRequest = SaveRequest::class;

    protected function getListingQuery()
    {
        return $this->model::select('id', 'car_id', 'name', 'serial_number')->with('car:id,name');
    }

    protected function getModelQuery(): Builder
    {
        return $this->model::select('id', 'car_id', 'name', 'serial_number')->with('car:id,name');
    }

    protected function saveCar(array $data): Car
    {
        return Car::updateOrCreate(['id' => $data['car']['id'] ?? null], $data['car']);
    }

    protected function save(array $data, ?int $id = null): Model
    {
        return DB::transaction(function () use ($id, $data) {
            $payload = Arr::only($data, ['name', 'serial_number']);
            $payload['car_id'] = $this->saveCar($data)->id;

            $model = $this->model::updateOrCreate(['id' => $id], $payload);

            return $model;
        });
    }
}
