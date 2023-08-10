<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DemoController;

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


Route::prefix('demo')->middleware('log_request')->group(function () {
    Route::get('/success_get', [DemoController::class, 'success_get']);
    Route::post('/success_post', [DemoController::class, 'success_post']);
    Route::get('/expected_get', [DemoController::class, 'expected_get']);
    Route::get('/error_get', [DemoController::class, 'error_get']);
    Route::get('/match_get', [DemoController::class, 'match_get']);
});
