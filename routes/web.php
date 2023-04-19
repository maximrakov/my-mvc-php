<?php

use App\Core\middlewares\CORSMiddleware;
use App\Core\Route;

Route::get('/ab[fsd]ba/{id}', [App\Controllers\SimpleController::class, 'index']);
Route::get('/document', [App\Controllers\SimpleController::class, 'show']);
