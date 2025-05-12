<?php

use App\Http\Controllers\ApiDocumentationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/documentation/{endpoint}', [ApiDocumentationController::class, 'show'])
    ->name('api.documentation.show');

Route::get('/api/documentation/group/{group}', [ApiDocumentationController::class, 'showGroupCollections'])
    ->name('api.documentation.group');
