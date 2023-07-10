<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Statistics\StatisticsController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::resource('/article', ArticleController::class)->withoutMiddleware('status');
    Route::resource('/user', UserController::class)->except('show');
    Route::resource('/role', RoleController::class)->except('show');
    Route::resource('/position', PositionController::class)->except(['show', 'create', 'update']);
    Route::resource('/department', DepartmentController::class)->except(['show', 'create', 'update']);
    Route::resource('/calendar', CalendarController::class)->except(['show', 'create']);
    Route::resource('/statistics', StatisticsController::class)->only(['index', 'store']);
    Route::resource('/city', CityController::class)->only(['index', 'create']);

    Route::get('/city/export', [CityController::class, 'export'])->name('city.export');
    Route::get('/department/export', [DepartmentController::class, 'export'])->name('department.export');
    Route::get('/position/export', [PositionController::class, 'export'])->name('position.export');
    Route::get('/role/export', [RoleController::class, 'export'])->name('role.export');
});

Auth::routes();
