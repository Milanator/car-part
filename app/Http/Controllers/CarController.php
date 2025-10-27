<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController extends Controller
{
    protected string $model = Car::class;

    protected string $pagePath = 'car';

    protected string $routeAs = 'car';

    protected function getListingItems()
    {
        return $this->model::select('id', 'name', 'registration_number', 'is_registered')->get();
    }
}
