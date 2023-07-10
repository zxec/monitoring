<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Monitoring\SuggestController;
use App\Http\Controllers\Monitoring\MonitoringController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes([
    'register' => false, // Если вы не хотите предоставлять регистрацию
    'reset' => false, // Если вы не хотите включать сброс пароля
    'verify' => false, // Если вы не хотите включать верификацию email
]);

Route::redirect('/', 'login', 301);

Route::middleware(['auth'])->group(function(){
    Route::get('monitorings/bid', [MonitoringController::class, 'indexBid'])->name('monitorings.indexBid');
    Route::get('monitorings/{bid}/create',[MonitoringController::class,'createFromBid'])->name('monitorings.createFromBid');
    Route::resource('monitorings', MonitoringController::class);

    Route::get('suggest-cities', [SuggestController::class, 'suggestCities'])->name('suggestCities');
    Route::get('suggest-streets', [SuggestController::class, 'suggestStreets'])->name('suggestStreets');
    Route::get('suggest-houses', [SuggestController::class, 'suggestHouses'])->name('suggestHouses');
});
