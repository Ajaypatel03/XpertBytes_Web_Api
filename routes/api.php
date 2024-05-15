<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\EmployController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\ServiceController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Open Routes
Route::post("register",[AdminController::class, "register"]);
Route::post("login",[AdminController::class, "login"]);

Route::get("profile",[AdminController::class, "profile"]);
Route::get("logout",[AdminController::class, "logout"]);

Route::apiResource('blog', BlogController::class);
Route::apiResource('client', ClientController::class);
Route::apiResource('contactUs', ContactUsController::class);
Route::apiResource('employ', EmployController::class);
Route::apiResource('quote', QuoteController::class);
Route::apiResource('service', ServiceController::class);


//Protected Routes
Route::group(['middleware' => 'auth:api'], function() {
    
    
});
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');