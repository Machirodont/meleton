<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\SimpleTokenAuth;
use Illuminate\Support\Facades\Route;

Route::any('/v1', [ApiController::class, 'index'])->middleware(SimpleTokenAuth::class);
