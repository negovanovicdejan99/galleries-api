<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);
Route::post('/galleries', [GalleryController::class, 'store']);
Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
Route::get('/author/{id}', [UserController::class, 'show']);


Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/refresh', [AuthController::class, 'refresh']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/auth-user', [AuthController::class, 'authUser']);