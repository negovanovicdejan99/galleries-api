<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::post('/galleries/{id}/comments', [CommentController::class, 'store']);
    Route::put('/edit-gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('/delete-comment/{id}', [CommentController::class, 'destroy']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
    Route::get('/auth-user', [AuthController::class, 'authUser']);
    Route::get('/auth-user-gallery', [AuthController::class, 'authUserGallery']);
});   

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);
Route::get('/author/{id}', [UserController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/refresh', [AuthController::class, 'refresh']);
Route::post('/register', [AuthController::class, 'register']);
