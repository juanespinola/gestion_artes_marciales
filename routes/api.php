<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FederationController;
use App\Http\Controllers\AssociationController;
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


Route::post("/login", [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post("/register", [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->prefix('association')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [AssociationController::class, 'index']);
    Route::get($idInThePath, [AssociationController::class, 'show']);
    Route::post("/", [AssociationController::class, 'store']);
    Route::put($idInThePath, [AssociationController::class, 'update']);
    Route::delete($idInThePath, [AssociationController::class, 'destroy']);
});

// Route::group(['prefix'=>'federation'], function () {
//     $idInThePath = '/{id}';
//     Route::get("/", [FederationController::class, 'index']);
//     Route::get($idInThePath, [FederationController::class, 'show']);
//     Route::post("/", [FederationController::class, 'store']);
//     Route::put($idInThePath, [FederationController::class, 'update']);
//     Route::delete($idInThePath, [FederationController::class, 'destroy']);
// });

// Route::group(['prefix'=>'association'], function () {
//     $idInThePath = '/{id}';
//     Route::get("/", [AssociationController::class, 'index']);
//     Route::get($idInThePath, [AssociationController::class, 'show']);
//     Route::post("/", [AssociationController::class, 'store']);
//     Route::put($idInThePath, [AssociationController::class, 'update']);
//     Route::delete($idInThePath, [AssociationController::class, 'destroy']);
// });

// Route::group(['prefix'=>'player'], function () {
//     $idInThePath = '/{id}';
//     Route::get('/', [PlayerController::class, 'index']);
//     Route::get($idInThePath, [PlayerController::class, 'show']);
//     Route::post('/', [PlayerController::class, 'store']);
//     Route::put($idInThePath, [PlayerController::class, 'update']);
    
//     Route::delete($idInThePath, [PlayerController::class, 'destroy'])->middleware('auth.token');
    
// });