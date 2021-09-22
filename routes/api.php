<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyAccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmployeeController;

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

Route::post('/register', [ RegisterController::class, 'store']);
Route::post('/login', [ LoginController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function(){
    //
    Route::match(['put', 'patch'], '/verify', [VerifyAccountController::class, 'verify']);
    Route::match(['put', 'patch'], '/employeeVerify', [VerifyAccountController::class, 'employeeVerify']);
    Route::apiResource('/transactions', TransactionController::class);
    Route::apiResource('/employees', EmployeeController::class);
    Route::apiResource('/employers', EmployerController::class);
});
