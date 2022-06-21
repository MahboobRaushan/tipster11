<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
 Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
  Route::post('forgot', [AuthController::class, 'forgot']);
  Route::post('reset', [AuthController::class, 'reset']);
   Route::get('getjackpot', [AuthController::class, 'getjackpot']);
    Route::get('getalljackpot', [AuthController::class, 'getalljackpot']);

  Route::get('testingvue', [AuthController::class, 'testingvue']);

  Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('emailchange', [AuthController::class, 'emailchange']);
    Route::post('passwordchange', [AuthController::class, 'passwordchange']);

    Route::post('deposit', [AuthController::class, 'deposit']);
    Route::post('withdraw', [AuthController::class, 'withdraw']);

    Route::get('getdeposit', [AuthController::class, 'getdeposit']);
    Route::get('getwithdraw', [AuthController::class, 'getwithdraw']);
     Route::get('getbet', [AuthController::class, 'getbet']);
    
    Route::post('placebet', [AuthController::class, 'placebet']);
   

    
  });
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('testing', [AuthController::class, 'testing']);
    Route::post('deposit', [AuthController::class, 'deposit']);
    Route::post('withdraw', [AuthController::class, 'withdraw']);
});


