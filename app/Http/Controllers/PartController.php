<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PartController extends Controller
{
    protected string $model = Part::class;

    protected string $pagePath = 'part';

    protected string $routeAs = 'part';

    protected array $filterable = ['name'];

    protected function getListingQuery()
    {
        return $this->model::select('id', 'name');
    }

    protected function save(Request $request, ?int $id = null): Model
    {
        $model = $this->model::updateOrCreate(['id' => $id], $request->only(['name']));

        return $model;
    }
}
