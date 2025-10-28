<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::apiResource('car', CarController::class);