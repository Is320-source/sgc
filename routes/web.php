<?php

use App\Http\Controllers\clientController;
use App\Http\Controllers\Dashboard\apartamentController;
use App\Http\Controllers\Dashboard\buildingController;
use App\Http\Controllers\Dashboard\otherController;
use App\Http\Controllers\Dashboard\PorterController;
use App\Http\Controllers\Dashboard\rateController;
use App\Http\Controllers\Dashboard\residentController;
use App\Http\Controllers\Dashboard\serviceController;
use App\Http\Controllers\Dashboard\typologyController;
use App\Http\Controllers\Dashboard\userController as DashboardUserController;
use App\Http\Controllers\godchildrenController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\Dashboard\paymentController;
use App\Http\Controllers\userController;
use App\Mail\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




#---------------------------- Routes of the Site --------------------------------------------#

# Pages of the site
// Route::get('/', [siteController::class, 'index'])->name('site.home');


Route::get('/', function(){
    return redirect()->route('dashboard.home');
});



#---------------------------- Routes of the Dashboard --------------------------------------------#


Route::prefix('cdm')->group(function () {
    Auth::routes(['register' => false]);
});


Route::middleware(['auth:web'])->prefix('cdm')->group(function () {


    Route::middleware(['adminCheck'])->group(function () {


        # Other Pages
        Route::get('homepage', [otherController::class, 'index'])->name('dashboard.home');
        Route::get('statics', [otherController::class, 'statistics'])->name('dashboard.statistics');
        Route::get('finances', [otherController::class, 'indexFinances'])->name('dashboard.finances');

        // Comunics
        Route::get('comunics', [otherController::class, '#'])->name('dashboard.comunics');

        # Admin
        Route::get('users', [DashboardUserController::class, 'index'])->name('dashboard.index.user');
        Route::post('user/insert', [DashboardUserController::class, 'store'])->name('dashboard.store.user');
        Route::get('user/profile/{id}', [DashboardUserController::class, 'show'])->name('dashboard.show.user');
        Route::put('user/update/{id}', [DashboardUserController::class, 'update'])->name('dashboard.update.user');
        Route::put('user/status/{id}', [DashboardUserController::class, 'status'])->name('dashboard.status.user');
        Route::put('user/password/{id}', [DashboardUserController::class, 'password'])->name('dashboard.password.user');
        Route::delete('user/delete/{id}', [DashboardUserController::class, 'destroy'])->name('dashboard.destroy.user');


        # Porters
        Route::get('porters', [PorterController::class, 'index'])->name('dashboard.index.porter');
        Route::any('porters/search', [PorterController::class, 'search'])->name('dashboard.search.porter');
        Route::any('porters/report', [PorterController::class, 'report'])->name('dashboard.report.porter');
        Route::post('porter/insert', [PorterController::class, 'store'])->name('dashboard.store.porter');
        Route::get('porter/profile/{id}', [PorterController::class, 'show'])->name('dashboard.show.porter');
        Route::put('porter/update/{id}', [PorterController::class, 'update'])->name('dashboard.update.porter');
        Route::put('porter/status/{id}', [PorterController::class, 'status'])->name('dashboard.status.porter');
        Route::put('porter/password/{id}', [PorterController::class, 'password'])->name('dashboard.password.porter');
        Route::delete('porter/delete/{id}', [PorterController::class, 'destroy'])->name('dashboard.destroy.porter');

        # Resident
        Route::get('residents', [residentController::class, 'index'])->name('dashboard.index.resident');
        // Route::get('resident/{id}', [residentController::class, 'show'])->name('dashboard.show.resident');
        Route::any('residents/search', [residentController::class, 'search'])->name('dashboard.search.resident');
        Route::any('residents/report', [residentController::class, 'report'])->name('dashboard.report.resident');
        Route::post('resident/insert', [residentController::class, 'store'])->name('dashboard.store.resident');
        Route::get('resident/document/{id}', [residentController::class, 'show'])->name('dashboard.show.resident');
        Route::put('resident/update/{id}', [residentController::class, 'update'])->name('dashboard.update.resident');
        Route::put('resident/status/{id}', [residentController::class, 'status'])->name('dashboard.status.resident');
        Route::put('resident/password/{id}', [residentController::class, 'password'])->name('dashboard.password.resident');
        Route::delete('resident/delete/{id}', [residentController::class, 'destroy'])->name('dashboard.destroy.resident');



        # Buiding
        Route::get('buildings', [buildingController::class, 'index'])->name('dashboard.index.building');
        Route::any('buildings/search', [buildingController::class, 'search'])->name('dashboard.search.building');
        Route::any('buildings/report', [buildingController::class, 'report'])->name('dashboard.report.building');
        Route::post('building/insert', [buildingController::class, 'store'])->name('dashboard.store.building');
        Route::get('building/profile/{id}', [buildingController::class, 'show'])->name('dashboard.show.building');
        Route::put('building/update/{id}', [buildingController::class, 'update'])->name('dashboard.update.building');
        Route::put('building/status/{id}', [buildingController::class, 'status'])->name('dashboard.status.building');
        Route::put('building/password/{id}', [buildingController::class, 'password'])->name('dashboard.password.building');
        Route::delete('building/delete/{id}', [buildingController::class, 'destroy'])->name('dashboard.destroy.building');


        # Tipology
        Route::get('typologies', [typologyController::class, 'index'])->name('dashboard.index.typology');
        Route::any('typologies/search', [typologyController::class, 'search'])->name('dashboard.search.typology');
        Route::any('typologies/report', [typologyController::class, 'report'])->name('dashboard.report.typology');
        Route::post('typology/insert', [typologyController::class, 'store'])->name('dashboard.store.typology');
        Route::get('typology/profile/{id}', [typologyController::class, 'show'])->name('dashboard.show.typology');
        Route::put('typology/update/{id}', [typologyController::class, 'update'])->name('dashboard.update.typology');
        Route::put('typology/status/{id}', [typologyController::class, 'status'])->name('dashboard.status.typology');
        Route::put('typology/password/{id}', [typologyController::class, 'password'])->name('dashboard.password.typology');
        Route::delete('typology/delete/{id}', [typologyController::class, 'destroy'])->name('dashboard.destroy.typology');


        # Apartament
        Route::get('apartaments', [apartamentController::class, 'index'])->name('dashboard.index.apartament');
        Route::any('apartaments/search', [apartamentController::class, 'search'])->name('dashboard.search.apartament');
        Route::any('apartaments/report', [apartamentController::class, 'report'])->name('dashboard.report.apartament');
        Route::post('apartament/insert', [apartamentController::class, 'store'])->name('dashboard.store.apartament');
        Route::get('apartament/profile/{id}', [apartamentController::class, 'show'])->name('dashboard.show.apartament');
        Route::put('apartament/update/{id}', [apartamentController::class, 'update'])->name('dashboard.update.apartament');
        Route::put('apartament/status/{id}', [apartamentController::class, 'status'])->name('dashboard.status.apartament');
        Route::put('apartament/password/{id}', [apartamentController::class, 'password'])->name('dashboard.password.apartament');
        Route::delete('apartament/delete/{id}', [apartamentController::class, 'destroy'])->name('dashboard.destroy.apartament');

        Route::get('apartaments/{building}', [apartamentController::class, 'apartamentsBuildings'])->name('dashboard.get.apartament');





        

        # Rate
        Route::get('rates', [rateController::class, 'index'])->name('dashboard.index.rate');
        Route::any('rates/search', [rateController::class, 'search'])->name('dashboard.search.rate');
        Route::any('rates/report', [rateController::class, 'report'])->name('dashboard.report.rate');
        Route::post('rate/insert', [rateController::class, 'store'])->name('dashboard.store.rate');
        Route::get('rate/profile/{id}', [rateController::class, 'show'])->name('dashboard.show.rate');
        Route::put('rate/update/{id}', [rateController::class, 'update'])->name('dashboard.update.rate');
        Route::put('rate/status/{id}', [rateController::class, 'status'])->name('dashboard.status.rate');
        Route::put('rate/password/{id}', [rateController::class, 'password'])->name('dashboard.password.rate');
        Route::delete('rate/delete/{id}', [rateController::class, 'destroy'])->name('dashboard.destroy.rate');

        Route::get('rates/{building}', [rateController::class, 'ratesBuildings'])->name('dashboard.get.rate');



        
        

        # payment
        Route::get('payments', [paymentController::class, 'index'])->name('dashboard.index.payment');
        Route::any('payment/search', [paymentController::class, 'search'])->name('dashboard.search.payment');
        Route::any('payment/report', [paymentController::class, 'report'])->name('dashboard.report.payment');
        Route::post('payment/insert', [paymentController::class, 'store'])->name('dashboard.store.payment');
        Route::get('payment/profile/{id}', [paymentController::class, 'show'])->name('dashboard.show.payment');
        Route::put('payment/update/{id}', [paymentController::class, 'update'])->name('dashboard.update.payment');
        Route::put('payment/status/{id}', [paymentController::class, 'status'])->name('dashboard.status.payment');
        Route::put('payment/password/{id}', [paymentController::class, 'password'])->name('dashboard.password.payment');
        Route::delete('payment/delete/{id}', [paymentController::class, 'destroy'])->name('dashboard.destroy.payment');

        Route::get('payments/{building}', [paymentController::class, 'paymentsBuildings'])->name('dashboard.get.payment');


        # Services
        Route::get('services', [serviceController::class, 'index'])->name('dashboard.index.service');
        Route::any('services/search', [serviceController::class, 'search'])->name('dashboard.search.service');
        Route::any('services/report', [serviceController::class, 'report'])->name('dashboard.report.service');
        Route::post('service/insert', [serviceController::class, 'store'])->name('dashboard.store.service');
        Route::get('service/profile/{id}', [serviceController::class, 'show'])->name('dashboard.show.service');
        Route::put('service/update/{id}', [serviceController::class, 'update'])->name('dashboard.update.service');
        Route::put('service/status/{id}', [serviceController::class, 'status'])->name('dashboard.status.service');
        Route::put('service/password/{id}', [serviceController::class, 'password'])->name('dashboard.password.service');
        Route::delete('service/delete/{id}', [serviceController::class, 'destroy'])->name('dashboard.destroy.service');

    });
});
