<?php

use App\Core\middlewares\CORSMiddleware;
use App\Core\Route;

Route::get('#^/document/{id}$#', [App\Controllers\Controller::class, 'index']);
