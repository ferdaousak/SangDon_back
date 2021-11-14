<?php

use App\Http\Controllers\DonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DemandeController;

use App\Http\Controllers\CentreController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\VilleController;

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
//Users api

Route::group(['middleware' => ['jwt.verify']], function () {

    // Mouad
    Route::get('/user', [UserController::class, 'getAuthenticatedUser']);
    Route::delete('/user', [UserController::class, 'delete']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
    Route::post('/user/{id}', [UserController::class, 'updateUser']);
    Route::get('/users', [UserController::class, 'allUsers']);
    Route::post('/user', [UserController::class, 'update']);


    //demandes api

    // Aymane
    Route::post('demande', [DemandeController::class, 'add']);
    Route::get('mes-demandes', [DemandeController::class, 'mesDemandes']);
    Route::get('demandes', [DemandeController::class, 'getAll']);
    Route::get('demandes/user/{id_user}', [DemandeController::class, 'showList']);
    Route::get('demande/{id_dem}', [DemandeController::class, 'getDemandeById']);
    Route::put('demande/{id_dem}', [DemandeController::class, 'update']);
    Route::post('demande/{id_dem}', [DemandeController::class, 'confirmDemande']);

    //dons api

    // Chaimae
    Route::get('/dons/next/{id_user}', [DonController::class, 'timeUntilNextDon']);
    Route::get('/dons/stats/year/{id_user}', [DonController::class, 'showDonbyYear']);
    Route::get('/dons/stats/{id_user}', [DonController::class, 'showStats']);
    Route::get('/dons/{id_user}', [DonController::class, 'showUserDons']);
    Route::get('dons/don/{id}', [DonController::class, 'show']);
    Route::apiResource('dons', DonController::class)->except(['show']);

    //centres api
    // Yakine
    Route::resource('centres', CentreController::class);
    Route::get('/centre/{ville_id}', [CentreController::class, 'getCentreByVilleId']);
    Route::get('/centreOuvert', [CentreController::class, 'centreOuvert']);

    //villes api
    // Najm eddine

    //RDV api
    Route::apiResource('rdv', RdvController::class);

    // type de sang API
    Route::get('type-sangs', [UserController::class, 'getTypeSangs']);
});

//Users api
// Mouad
Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/register', [UserController::class, 'register']);
Route::resource('villes', VilleController::class);

Route::post('/reset-password-request', [PasswordResetRequestController::class, 'sendPasswordResetEmail']);
Route::post('/change-password', [ChangePasswordController::class, 'passwordResetProcess']);
