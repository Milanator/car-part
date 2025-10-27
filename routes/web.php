<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::resource('car', CarController::class);
