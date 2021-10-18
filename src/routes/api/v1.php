<?php

use Illuminate\Support\Facades\Route;

Route::get('/movies', [\App\Http\Controllers\API\V1\MovieController::class, 'index']);
