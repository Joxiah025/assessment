<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('dump', [ColumnController::class, 'sqlDump']);
Route::get('download', [ColumnController::class, 'download']);

Route::get('columns', [ColumnController::class, 'index']);
Route::post('columns', [ColumnController::class, 'store']);
Route::put('columns', [ColumnController::class, 'update']);
Route::delete('columns/{id}', [ColumnController::class, 'destroy']);

Route::get('card', [CardController::class, 'index']);
Route::post('card', [CardController::class, 'store']);
Route::put('card/{id}', [CardController::class, 'update']);
Route::delete('card/{id}', [CardController::class, 'destroy']);
