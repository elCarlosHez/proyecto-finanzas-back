<?php

use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\TaxesController;
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
Route::get('/health', function () {
    return json_encode(['message' => 'Server is up']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::post('/user', [UserController::class, 'updateUserData']);
    Route::post('/migrate-user', [UserController::class, 'migrateUser']);
    Route::post('/expense', [ExpensesController::class, 'store']);
    Route::get('/expense', [ExpensesController::class, 'index']);
    Route::get('/expense/resume', [ExpensesController::class, 'getResume']);
    Route::post('/income', [IncomesController::class, 'store']);
    Route::get('/income', [IncomesController::class, 'index']);
    Route::get('/taxes', [TaxesController::class, 'index']);
    Route::get('/deductions', [TaxesController::class, 'getDeductions']);
    Route::post('/deductions', [TaxesController::class, 'updateDeductions']);
    Route::post('/investment', [InvestmentController::class, 'getAnInvestment']);
    Route::post('/onboarding', [UserController::class, 'updateUserData']);
});
