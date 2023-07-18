<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Api\Brands\VehiculeBrandController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']); 
    Route::post('/verify', [App\Http\Controllers\Api\AuthController::class, 'verify'])->name('verify');
    // Send reset password mail
    //Route::post('reset-password', [App\Http\Controllers\Api\AuthController::class, 'sendPasswordResetLink']);
        
    // handle reset password form process
    Route::post('reset/password', [App\Http\Controllers\Api\AuthController::class, 'callResetPassword']);
    
    
    Route::post('forgot-password', 'Api\AuthController@forgot_password');

    Route::post('reset-password', 'Api\AuthController@reset_password');
});

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::name('users.')->group(function(){

        Route::resource('users', UserController::class);
        Route::post('/users/verify-password', [App\Http\Controllers\Api\UserController::class, 'verifyPassword'])->name('verify');
        Route::post('/users/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword'])->name('changePassword');


    });


    //Route::post('/entrar', [App\Http\Controllers\Api\UserController::class, 'login'])->name('login');

    Route::post('/sendAlert', [App\Http\Controllers\Api\UserController::class, 'sendAlert'])->name('alert');
    Route::get('/messages', [App\Http\Controllers\Api\UserController::class, 'indexMessageLimit'])->name('MessageLimit');
    Route::post('/sms/transfer', [App\Http\Controllers\Api\UserController::class, 'smsTransfer'])->name('smsTransfer');
    //Route::get('/sms/request-for', [App\Http\Controllers\Api\UserController::class, 'indexMessageLimit'])->name('MessageLimit');

    Route::name('pets.')->group(function(){

        Route::resource('pets', PetController::class);

        Route::post('pets_status/{pet}',  [App\Http\Controllers\Api\PetController::class, 'updateStatus'])->name('statusPets');

    });

    Route::name('contacts.')->group(function(){

        Route::resource('contacts', ContactController::class);

        Route::put('contacts/favorite/{contact}', [App\Http\Controllers\Api\ContactController::class, 'favorite']);

    });

    Route::name('vehicules_brands.')->group(function(){

        Route::resource('vehicules_brands', Brands\VehiculeBrandController::class);

    });

    Route::name('vehicules_models.')->group(function(){

        Route::resource('vehicules_models', Model\VehiculeModelController::class);

    });

    Route::name('colors.')->group(function(){

        Route::resource('colors', ColorController::class);

    });

    Route::name('vehicules.')->group(function(){

        Route::resource('vehicules', VehiculeController::class);
        Route::post('vehicules_status/{vehicule}',  [App\Http\Controllers\Api\VehiculeController::class, 'updateStatus'])->name('statusVehicules');


    });

    Route::name('devices.')->group(function(){

        Route::resource('devices', DeviceController::class);

    });

    Route::name('electronics.')->group(function(){

        Route::resource('electronics', ElectronicController::class);
        
        Route::post('electronics_status/{electronic}',  [App\Http\Controllers\Api\ElectronicController::class, 'updateStatus'])->name('statusElectronic');

    });

    Route::name('electronics_models.')->group(function(){

        Route::resource('electronics_models', Model\ElectronicsModelsController::class);

    });

    Route::name('electronics_brands.')->group(function(){

        Route::resource('electronics_brands', Brands\ElectroncsBrandsController::class);

    });

    Route::name('alerts.')->group(function(){

        Route::resource('alerts', AlertRegisterController::class);

        Route::get('alerts_received', [App\Http\Controllers\Api\AlertRegisterController::class, 'indexReceived'])->name('receivedIndex');

        Route::get('alerts_categories', [App\Http\Controllers\Api\AlertRegisterController::class, 'indexReceivedAllType'])->name('receivedIndex');

        Route::get('alerts_all', [App\Http\Controllers\Api\AlertRegisterController::class, 'indexAll'])->name('allIndex');
        
        Route::get('alerts_categories/all', [App\Http\Controllers\Api\AlertRegisterController::class, 'indexAllCategorie'])->name('allIndexCategories');

    });


});


