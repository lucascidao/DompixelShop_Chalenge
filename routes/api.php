<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response('API Fullstack Job Test - DomPixel running', 200);
});

Route::post('register', [ProductController::class, 'register']);
Route::post('update/{id}', [ProductController::class, 'update']);
Route::delete('delete/{id}', [ProductController::class, 'delete']);
Route::get('index', [ProductController::class, 'list']);
Route::get('show/{id}', [ProductController::class, 'show']);




