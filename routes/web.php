<?php

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', fn(): View => view('app'))->where('any', '.*');