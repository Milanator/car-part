<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\SaveRequest;
use App\Models\{Car, Part};
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    protected string $model = Car::class;
    protected array $filterable = ['name', 'registration_number', 'is_registered'];
    protected string $formRequest = SaveRequest::class;

    protected function getListingQuery()
    {
        return $this->model::select('id', 'name', 'registration_number', 'is_registered');
    }

    protected function getModelQuery(): Builder
    {
        return $this->model::with('parts:id,car_id,name,serial_number');
    }

    protected function saveParts(Car $model, array $data): void
    {
        foreach ($data['parts'] as $part) {
            if (empty($part)) {
                continue;
            }

            $part['car_id'] = $model->id;

            $partIds[] = Part::updateOrCreate(['serial_number' => $part['serial_number']], $part)->id;
        }

        // delete unmodified parts
        if (!empty($partIds)) {
            Part::whereCarId($model->id)->whereNotIn('id', $partIds)->delete();
        }
    }

    protected function save(array $data, ?int $id = null): Model
    {
        return DB::transaction(function () use ($id, $data): Car {
            $model = $this->model::updateOrCreate(['id' => $id], Arr::only($data, ['name', 'registration_number', 'is_registered']));

            $this->saveParts($model, $data);

            return $model;
        });
    }
}
