<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FederationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupCategoryController;
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
Route::get("/", function () {
    return "estamos Online";
});

Route::middleware('auth:sanctum')->prefix('association')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [AssociationController::class, 'index']);
    Route::get($idInThePath, [AssociationController::class, 'show']);
    Route::post("/", [AssociationController::class, 'store']);
    Route::put($idInThePath, [AssociationController::class, 'update']);
    Route::delete($idInThePath, [AssociationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('federation')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [FederationController::class, 'index']);
    Route::get($idInThePath, [FederationController::class, 'show']);
    Route::post("/", [FederationController::class, 'store']);
    Route::put($idInThePath, [FederationController::class, 'update']);
    Route::delete($idInThePath, [FederationController::class, 'destroy']);
});

// necesita tener el middleware para acceder a los permisos, roles
Route::middleware('auth:sanctum')->prefix('user')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [UsersController::class, 'index']);
    Route::get($idInThePath, [UsersController::class, 'edit']);
    Route::post("/", [UsersController::class, 'store']);
    Route::put($idInThePath, [UsersController::class, 'update']);
    Route::delete($idInThePath, [UsersController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->prefix('rol')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [RolController::class, 'index']);
    Route::get($idInThePath, [RolController::class, 'edit']);
    Route::post("/", [RolController::class, 'store']);
    Route::put($idInThePath, [RolController::class, 'update']);
    Route::delete($idInThePath, [RolController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->prefix('permission')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [PermissionController::class, 'index']);
    Route::get($idInThePath, [PermissionController::class, 'edit']);
    Route::post("/", [PermissionController::class, 'store']);
    Route::put($idInThePath, [PermissionController::class, 'update']);
    Route::delete($idInThePath, [PermissionController::class, 'destroy']);
    
});

Route::middleware('auth:sanctum')->prefix('permissionsbygroup')->group(function (){
    $idInThePath = "/{name}";
    Route::get("/", [PermissionController::class, 'getPermissionsByGroup']);
    Route::get($idInThePath, [PermissionController::class, 'getPermissionsByGroupName']);
});

Route::middleware('auth:sanctum')->prefix('sport')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [SportController::class, 'index']);
    Route::get($idInThePath, [SportController::class, 'edit']);
    Route::post("/", [SportController::class, 'store']);
    Route::put($idInThePath, [SportController::class, 'update']);
    Route::delete($idInThePath, [SportController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('category')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [CategoryController::class, 'index']);
    Route::get($idInThePath, [CategoryController::class, 'edit']);
    Route::post("/", [CategoryController::class, 'store']);
    Route::put($idInThePath, [CategoryController::class, 'update']);
    Route::delete($idInThePath, [CategoryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('groupcategory')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [GroupCategoryController::class, 'index']);
    Route::get($idInThePath, [GroupCategoryController::class, 'edit']);
    Route::post("/", [GroupCategoryController::class, 'store']);
    Route::put($idInThePath, [GroupCategoryController::class, 'update']);
    Route::delete($idInThePath, [GroupCategoryController::class, 'destroy']);
});


// Route::group(['prefix'=>'user'], function () {
//     $idInThePath = '/{id}';
//     Route::get("/", [UsersController::class, 'index']);
//     Route::get($idInThePath, [UsersController::class, 'show']);
//     Route::post("/", [UsersController::class, 'store']);
//     Route::put($idInThePath, [UsersController::class, 'update']);
//     Route::delete($idInThePath, [UsersController::class, 'destroy']);
// });

// Route::group(['prefix'=>'association'], function () {
//     $idInThePath = '/{id}';
//     Route::get("/", [AssociationController::class, 'index']);
//     Route::get($idInThePath, [AssociationController::class, 'show']);
//     Route::post("/", [AssociationController::class, 'store']);
//     Route::put($idInThePath, [AssociationController::class, 'update']);
//     Route::delete($idInThePath, [AssociationController::class, 'destroy']);
// });



// Route::group(['prefix'=>'federation'], function () {
//     $idInThePath = '/{id}';
//     Route::get("/", [FederationController::class, 'index']);
//     Route::get($idInThePath, [FederationController::class, 'show']);
//     Route::post("/", [FederationController::class, 'store']);
//     Route::put($idInThePath, [FederationController::class, 'update']);
//     Route::delete($idInThePath, [FederationController::class, 'destroy']);
// });