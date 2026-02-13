<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\FAQController;

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
| Admin guards Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function() {
    /*
    |--------------------------------------------------------------------------
    | Story
    |--------------------------------------------------------------------------
    */

    Route::get('/get-story-fields', [StoryController::class, 'get']);
    Route::get('/get-story/{id}' , [StoryController::class, 'get']);
    Route::post('/add-story', [StoryController::class, 'store']);
    Route::put('/update-story/{id}' , [StoryController::class, 'update']);
    Route::delete('/delete-story/{id}', [StoryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */

    Route::get('/get-faq/' , [FAQController::class, 'get']);
    Route::post('/add-faq/' , [FAQController::class, 'store']);
    Route::put('/edit-faq/{id}' , [FAQController::class, 'update']);
    Route::delete('/delete-faq/{id}', [FAQController::class, 'delete']);

    /*
    |--------------------------------------------------------------------------
    | Privacy Policy
    |--------------------------------------------------------------------------
    */

    

    /*
    |--------------------------------------------------------------------------
    | About Us
    |--------------------------------------------------------------------------
    */

    Route::post('/admin/logout' , [AdminController::class , 'logout']);
});



/*
|--------------------------------------------------------------------------
| User guards Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth:user'] , 'prefix' => 'user'], function() {


    Route::post('/user/logout' , [UserController::class , 'logout']);
});
