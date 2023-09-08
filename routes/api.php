<?php

use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Route;

Route::apiResource('estates', EstateController::class)->only(['index']);
