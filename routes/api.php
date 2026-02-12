<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoryController;

/*
|--------------------------------------------------------------------------
| Login - Register Routes
|--------------------------------------------------------------------------
*/
Route::post('/user/register' , [UserController::class , 'register']);
Route::post('/user/login' , [UserController::class , 'register']);

Route::post('/admin/register/' , [AdminController::class , 'register']);
Route::post('/admin/login' , [AdminController::class , 'login']);

/*
|--------------------------------------------------------------------------
| User guards Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth:user'] , 'prefix' => 'user'], function() {
    

    Route::post('/user/logout' , [UserController::class , 'logout']);
});

/*
|--------------------------------------------------------------------------
| Admin guards Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:admin'] , 'prefix' => 'admin'], function() {
    /*
    |--------------------------------------------------------------------------
    | Story Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/get-story-fields', [StoryController::class, 'get']);
    Route::post('/add-story', [StoryController::class, 'store']);
    Route::delete('/delete-story/{id}', [StoryController::class, 'destroy']);

    Route::post('/admin/logout' , [AdminController::class , 'logout']);
});
