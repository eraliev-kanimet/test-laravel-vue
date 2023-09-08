<?php

use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Route;

Route::apiResource('estates', EstateController::class)->only(['index']);

Route::get('estates/get_min_and_max_price', [EstateController::class, 'getMinAndMaxPrice']);
