<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('recipies', App\Http\Controllers\Api\RecipeController::class);
