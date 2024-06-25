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
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StatusEventController;
use App\Http\Controllers\TypesEventController;
use App\Http\Controllers\MediaEventController;
use App\Http\Controllers\EntryCategoryController;
use App\Http\Controllers\BeltController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\NewsController;


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


Route::get("/", function () {
    return "estamos Online";
});
Route::post("/login", [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post("/register", [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get("/federations", [App\Http\Controllers\OrganizationController::class, 'federations']);
Route::get("/federations/{federation_id}", [App\Http\Controllers\OrganizationController::class, 'federation']);
Route::get("/federations/{federation_id}/news", [App\Http\Controllers\OrganizationController::class, 'news']);
Route::get("/federations/{federation_id}/events", [App\Http\Controllers\OrganizationController::class, 'events']);
Route::get("/events/{event_id}/eventdetail", [App\Http\Controllers\OrganizationController::class, 'event_detail']);


Route::middleware('auth:sanctum')->prefix('association')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [AssociationController::class, 'index']);
    Route::get($idInThePath, [AssociationController::class, 'show']);
    Route::post("/", [AssociationController::class, 'store']);
    Route::put($idInThePath, [AssociationController::class, 'update']);
    Route::delete($idInThePath, [AssociationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('associationcontact')->group(function (){
    $idInThePath = '/{id}';
    Route::put($idInThePath, [AssociationController::class, 'update_contacts']);
});
Route::middleware('auth:sanctum')->prefix('associationauthoritie')->group(function (){
    $idInThePath = '/{id}';
    Route::put($idInThePath, [AssociationController::class, 'update_authorities']);
});


Route::middleware('auth:sanctum')->prefix('federation')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [FederationController::class, 'index']);
    Route::get($idInThePath, [FederationController::class, 'show']);
    Route::post("/", [FederationController::class, 'store']);
    Route::put($idInThePath, [FederationController::class, 'update']);
    Route::delete($idInThePath, [FederationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('federationcontact')->group(function (){
    $idInThePath = '/{id}';
    Route::put($idInThePath, [FederationController::class, 'update_contacts']);
});
Route::middleware('auth:sanctum')->prefix('federationauthoritie')->group(function (){
    $idInThePath = '/{id}';
    Route::put($idInThePath, [FederationController::class, 'update_authorities']);
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

Route::middleware('auth:sanctum')->prefix('event')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [EventController::class, 'index']);
    Route::get($idInThePath, [EventController::class, 'edit']);
    Route::post("/", [EventController::class, 'store']);
    Route::put($idInThePath, [EventController::class, 'update']);
    Route::delete($idInThePath, [EventController::class, 'destroy']);    
});

Route::middleware('auth:sanctum')->prefix('eventcontent')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [EventController::class, 'index']);
    Route::put($idInThePath, [EventController::class, 'update_event_content']);
});

Route::middleware('auth:sanctum')->prefix('typesevent')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [TypesEventController::class, 'index']);
    Route::get($idInThePath, [TypesEventController::class, 'edit']);
    Route::post("/", [TypesEventController::class, 'store']);
    Route::put($idInThePath, [TypesEventController::class, 'update']);
    Route::delete($idInThePath, [TypesEventController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('statusevent')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [StatusEventController::class, 'index']);
    Route::get($idInThePath, [StatusEventController::class, 'edit']);
    Route::post("/", [StatusEventController::class, 'store']);
    Route::put($idInThePath, [StatusEventController::class, 'update']);
    Route::delete($idInThePath, [StatusEventController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->prefix('location')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [LocationController::class, 'index']);
    Route::get($idInThePath, [LocationController::class, 'edit']);
    Route::post("/", [LocationController::class, 'store']);
    Route::put($idInThePath, [LocationController::class, 'update']);
    Route::delete($idInThePath, [LocationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('mediaevent')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [MediaEventController::class, 'index']);
    Route::get($idInThePath, [MediaEventController::class, 'edit']);
    Route::post("/", [MediaEventController::class, 'store']);
    Route::put($idInThePath, [MediaEventController::class, 'update']);
    Route::delete($idInThePath, [MediaEventController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('entrycategories')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [EntryCategoryController::class, 'index']);
    Route::get($idInThePath, [EntryCategoryController::class, 'edit']);
    Route::post("/", [EntryCategoryController::class, 'store']);
    Route::put($idInThePath, [EntryCategoryController::class, 'update']);
    Route::delete($idInThePath, [EntryCategoryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('belt')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [BeltController::class, 'index']);
    Route::get($idInThePath, [BeltController::class, 'edit']);
    Route::post("/", [BeltController::class, 'store']);
    Route::put($idInThePath, [BeltController::class, 'update']);
    Route::delete($idInThePath, [BeltController::class, 'destroy']);
});

// falta separar el admin del atleta, porque estan juntos
Route::middleware('auth:sanctum')->prefix('inscription')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [InscriptionController::class, 'index']);
    Route::get($idInThePath, [InscriptionController::class, 'edit']);
    Route::post("/", [InscriptionController::class, 'store']);
    Route::put($idInThePath, [InscriptionController::class, 'update']);
    Route::delete($idInThePath, [InscriptionController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('new')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [NewsController::class, 'index']);
    Route::get($idInThePath, [NewsController::class, 'edit']);
    Route::post("/", [NewsController::class, 'store']);
    Route::put($idInThePath, [NewsController::class, 'update']);
    Route::delete($idInThePath, [NewsController::class, 'destroy']);
});

Route::group(['prefix'=>'athlete'], function () {
    Route::post("/login", [App\Http\Controllers\Auth\Athlete\LoginController::class, 'login']);
    Route::post("/register", [App\Http\Controllers\Auth\Athlete\RegisterController::class, 'register']);
    Route::get("/federations", [FederationController::class, "getFederations"]);

    Route::middleware('auth:sanctum')->prefix('entrycategories')->group(function (){
        $idInThePath = '/{id}';
        Route::get("/", [EntryCategoryController::class, 'getEntryForRegistratioAthlete']);
    });

    Route::middleware('auth:sanctum')->prefix('inscription')->group(function (){
        Route::post("/create", [InscriptionController::class, 'setEntryForRegistratioAthlete']);
    });

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