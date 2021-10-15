<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


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

Route::post('signup',[UserController::class,'signup']);
Route::post('login',[UserController::class,'login']);
Route::get('productlist',[ProductController::class,'index']);
Route::post('addproduct',[ProductController::class,'addproduct']);
Route::get('editproduct/{id}',[ProductController::class,'editproduct']);
Route::post('updateproduct',[ProductController::class,'updateproduct']);
Route::delete('deleteproduct/{id}',[ProductController::class,'deleteproduct']);
Route::get('categorylist',[CategoryController::class,'index']);
Route::post('addcategory',[CategoryController::class,'addcategory']);
Route::get('editcategory/{id}',[CategoryController::class,'editcategory']);
Route::post('updatecategory',[CategoryController::class,'updatecategory']);
Route::delete('deletecategory/{id}',[CategoryController::class,'deletecategory']);



