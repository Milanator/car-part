<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;
use Illuminate\Support\Facades\Route;

Route::apiResource('car', CarController::class);
Route::apiResource('part', PartController::class);