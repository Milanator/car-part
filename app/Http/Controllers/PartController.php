<?php

namespace App\Http\Controllers;

use App\Http\Requests\Part\SaveRequest;
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

    protected function save(array $data, ?int $id = null): Model
    {
        return DB::transaction(fn () => $this->model::updateOrCreate(['id' => $id], Arr::only($data, ['name', 'serial_number'])));
    }
}
