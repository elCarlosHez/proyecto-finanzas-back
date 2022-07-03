<?php

use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/get-token', [UserController::class, 'getUsertoken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/expense', [IncomesController::class, 'store']);
    Route::get('/expense', [IncomesController::class, 'index']);
    Route::post('/income', [IncomesController::class, 'store']);
    Route::get('/income', [IncomesController::class, 'index']);
});
