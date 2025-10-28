<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartController extends Controller
{
    protected string $model = Part::class;
    protected string $pagePath = 'part';
    protected string $routeAs = 'part';
    protected array $filterable = ['name'];

    protected function getListingQuery()
    {
        return $this->model::select('id', 'car_id', 'name', 'serial_number')->with('car:id,name');
    }

    protected function getModelQuery(): Builder
    {
        return $this->model::select('id', 'car_id', 'name', 'serial_number')->with('car:id,name');
    }

    protected function save(Request $request, ?int $id = null): Model
    {
        return DB::transaction(function () use ($request, $id) {
            return $this->model::updateOrCreate(['id' => $id], $request->only(['name', 'serial_number']));
        });
    }
}
