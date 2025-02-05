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
use App\Http\Controllers\MediaNewController;
use App\Http\Controllers\MatchBracketController;
use App\Http\Controllers\TypesVictoryController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\TypeDocumentController;
use App\Http\Controllers\BeltHistoryController;
use App\Http\Controllers\RequestAutorizationController;
use App\Http\Controllers\TypeRequestController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\MinorAuthorizationController;
use App\Http\Controllers\SanctionController;


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

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get("/", function () {
    return "estamos Online";
});
Route::post("/login", [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post("/register", [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get("/logout", [App\Http\Controllers\Auth\LoginController::class, 'logout']);
   

//apartado de usuario offline
Route::get("/federations", [App\Http\Controllers\OrganizationController::class, 'federations']);
Route::get("/federations/{federation_id}", [App\Http\Controllers\OrganizationController::class, 'federation']);
Route::get("/federations/{federation_id}/news", [App\Http\Controllers\OrganizationController::class, 'news']);
Route::get("/news/{new_id}/newdetail", [App\Http\Controllers\OrganizationController::class, 'new_detail']);

Route::get("/federations/{federation_id}/events", [App\Http\Controllers\OrganizationController::class, 'events']);
Route::get("/events/{event_id}/eventdetail", [App\Http\Controllers\OrganizationController::class, 'event_detail']);
Route::post("/events/{event_id}/matchbrackets", [App\Http\Controllers\OrganizationController::class, 'matchBrackets']);
Route::post("/events/{event_id}/groupbrackets", [App\Http\Controllers\OrganizationController::class, 'groupBrackets']);
Route::get("/events/{event_id}/registered", [App\Http\Controllers\OrganizationController::class, 'athletesInscription']);
Route::get("/events/{event_id}/schedules", [App\Http\Controllers\OrganizationController::class, 'schedules']);
Route::get("/athleteswinlose", [App\Http\Controllers\OrganizationController::class, 'getAllAthletesWinLose']);
Route::get("/athleteprofilewinlose/{athlete_id}", [App\Http\Controllers\OrganizationController::class, 'getAthleteProfileWinLose']);
Route::get("/athleteeventmatchwinlose/{athlete_id}", [App\Http\Controllers\OrganizationController::class, 'getAthleteEventMatchWinLoseInformation']);
Route::post("/getAthleteRanking", [App\Http\Controllers\OrganizationController::class, 'getAthleteRanking']);
Route::get("/pastevents/{federation_id}", [App\Http\Controllers\OrganizationController::class, 'pastEvents']);


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
    Route::get("/event/{event_id}", [EntryCategoryController::class, 'index']);
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

Route::post("/inscription", [InscriptionController::class, 'index']);
// falta separar el admin del atleta, porque estan juntos
Route::middleware('auth:sanctum')->prefix('inscription')->group(function (){
    $idInThePath = '/{id}';
    // Route::post("/", [InscriptionController::class, 'index']);
    Route::get($idInThePath, [InscriptionController::class, 'edit']);
    // Route::post("/", [InscriptionController::class, 'store']);
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

Route::middleware('auth:sanctum')->prefix('medianew')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [MediaNewController::class, 'index']);
    Route::get($idInThePath, [MediaNewController::class, 'edit']);
    Route::post("/", [MediaNewController::class, 'store']);
    Route::put($idInThePath, [MediaNewController::class, 'update']);
    Route::delete($idInThePath, [MediaNewController::class, 'destroy']);
});

// Route::post("/matchbracket", [MatchBracketController::class, 'index']);
// Route::post("/matchbracket/nextphase", [MatchBracketController::class, 'finishMatchBracket']);
Route::middleware('auth:sanctum')->prefix('matchbracket')->group(function (){
    $idInThePath = '/{id}';
    Route::post("/", [MatchBracketController::class, 'index']);
    Route::post("/check", [MatchBracketController::class, 'checkMathBracket']);
    Route::post("/generate", [MatchBracketController::class, 'generateMatchBrackets']);
    Route::post("/nextphase", [MatchBracketController::class, 'finishMatchBracket']);
});

Route::middleware('auth:sanctum')->prefix('typevictory')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [TypesVictoryController::class, 'index']);
    Route::get($idInThePath, [TypesVictoryController::class, 'edit']);
    Route::post("/", [TypesVictoryController::class, 'store']);
    Route::put($idInThePath, [TypesVictoryController::class, 'update']);
    Route::delete($idInThePath, [TypesVictoryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('academy')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [AcademyController::class, 'index']);
    Route::get($idInThePath, [AcademyController::class, 'edit']);
    Route::post("/", [AcademyController::class, 'store']);
    Route::put($idInThePath, [AcademyController::class, 'update']);
    Route::delete($idInThePath, [AcademyController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('city')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/bycountry".$idInThePath, [CityController::class, 'index']);
    Route::get($idInThePath, [CityController::class, 'edit']);
    Route::post("/", [CityController::class, 'store']);
    Route::put($idInThePath, [CityController::class, 'update']);
    Route::delete($idInThePath, [CityController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('country')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [CountryController::class, 'index']);
    Route::get($idInThePath, [CountryController::class, 'edit']);
    Route::post("/", [CountryController::class, 'store']);
    Route::put($idInThePath, [CountryController::class, 'update']);
    Route::delete($idInThePath, [CountryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('requestautorization')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [RequestAutorizationController::class, 'index']);
    Route::get($idInThePath, [RequestAutorizationController::class, 'edit']);
    Route::post("/", [RequestAutorizationController::class, 'store']);
    Route::put($idInThePath, [RequestAutorizationController::class, 'update']);
    Route::delete($idInThePath, [RequestAutorizationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('typerequest')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [TypeRequestController::class, 'index']);
    Route::get($idInThePath, [TypeRequestController::class, 'edit']);
    Route::post("/", [TypeRequestController::class, 'store']);
    Route::put($idInThePath, [TypeRequestController::class, 'update']);
    Route::delete($idInThePath, [TypeRequestController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('ranking')->group(function (){
    Route::get("/", [RankingController::class, 'update']);
});


Route::middleware('auth:sanctum')->prefix('profile')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [UsersController::class, 'getProfile']);
    Route::post("/", [UsersController::class, 'updateProfile']);
});


Route::middleware('auth:sanctum')->prefix('athlete')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [AthleteController::class, 'index']);
    // Route::get($idInThePath, [AthleteController::class, 'show']);
    // Route::post("/", [AthleteController::class, 'store']);
    // Route::put($idInThePath, [AthleteController::class, 'update']);
    // Route::delete($idInThePath, [AthleteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('minor_authorization')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/", [MinorAuthorizationController::class, 'index']);
    Route::get($idInThePath, [MinorAuthorizationController::class, 'edit']);
    Route::put($idInThePath, [MinorAuthorizationController::class, 'update']);
    Route::post("/uploaddocument", [MinorAuthorizationController::class, 'uploadDocument']);

});

Route::middleware('auth:sanctum')->prefix('sanction')->group(function (){
    $idInThePath = '/{id}';
    Route::get("/{athlete_id}/athletes", [SanctionController::class, 'index']);
    Route::get($idInThePath, [SanctionController::class, 'edit']);
    Route::post("/", [SanctionController::class, 'store']);
    Route::put($idInThePath, [SanctionController::class, 'update']);
    Route::delete($idInThePath, [SanctionController::class, 'destroy']);
});




// parte de atletas
Route::group(['prefix'=>'athlete'], function () {
    Route::post("/login", [App\Http\Controllers\Auth\Athlete\LoginController::class, 'login']);
    Route::post("/register", [App\Http\Controllers\Auth\Athlete\RegisterController::class, 'register']);
    Route::get("/logout", [App\Http\Controllers\Auth\Athlete\LoginController::class, 'logout']);
    

    // este se genera al registrarse
    Route::post("/generatemembershipfee", [MembershipController::class, 'generateMemberShipFee']);

    Route::get("/federations", [FederationController::class, "getFederations"]);
    Route::get("/associations/{federation_id}", [AssociationController::class, "getAssociations"]);
    Route::post("/cities", [CityController::class, 'getCities']);
    Route::get("/countries", [CountryController::class, 'getCountries']);
    Route::get("/typesdocument", [TypeDocumentController::class, 'getTypesDocument']);
    Route::get("/academies", [AcademyController::class, 'getAcademies']);
    Route::post("/belts", [BeltController::class, 'getBelts']);
    
    Route::post("/payment/create", [PaymentController::class, 'createPayment']);
    Route::withoutMiddleware('throttle:60,1')->group(function () {
        Route::post("/payment/confirm", [PaymentController::class, 'confirmPaymentBancard']);
    });

    // requiere que el atleta este conectado para registrarse
    Route::middleware('auth:sanctum')->prefix('entrycategories')->group(function (){
        $idInThePath = '/{id}';
        Route::get("/", [EntryCategoryController::class, 'getEntryForRegistratioAthlete']);
    });
    
    Route::middleware('auth:sanctum')->prefix('inscription')->group(function (){
        Route::post("/create", [InscriptionController::class, 'setEntryForRegistratioAthlete']);
    });

    
    Route::middleware('auth:sanctum')->group(function (){
        //si el atleta esta conectado
        Route::get("/profile", [AthleteController::class, 'getProfile']);
        Route::post("/profile", [AthleteController::class, 'updateProfile']);

       
        Route::post("/updatebelthistory", [AthleteController::class, 'updateBeltHistory']);
        
        Route::post("/getathletemembershipfee", [AthleteController::class, 'getAthleteMembershipFee']);
        Route::post("/getathleteparticipatedevent", [AthleteController::class, 'getAthleteParticipatedEvents']);
        Route::put("/paymentmembershipfee/{id}", [MembershipController::class, 'paymentMemberShipFee']);
        Route::post("/getathletemembershipfeepayment", [AthleteController::class, 'getAthleteMembershipFeePayment']);
        Route::post("/getathleteinscriptionpayment", [AthleteController::class, 'getAthleteInscriptionPayment']);
        Route::get("/getmembershipfee/{id}", [MembershipController::class, 'getMemberShipFee']);
        Route::get("/getinscription/{id}", [InscriptionController::class, 'getInscription']);
        Route::get("/minor_authorization", [AthleteController::class, 'getMinorAuthorization']);
        



        Route::middleware('auth:sanctum')->prefix('belthistory')->group(function (){
            $idInThePath = '/{id}';
            Route::get("/", [BeltHistoryController::class, 'index']);
            Route::get($idInThePath, [BeltHistoryController::class, 'edit']);
            Route::post("/", [BeltHistoryController::class, 'store']);
            Route::put($idInThePath, [BeltHistoryController::class, 'update']);
            Route::delete($idInThePath, [BeltHistoryController::class, 'destroy']);
        });

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