<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/{id}', [\App\Http\Controllers\DashboardController::class, 'userDashboard'])->name('udashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/adashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('adashboard');
Route::middleware(['auth:sanctum', 'verified'])->get(
    '/pendientes',
    [\App\Http\Controllers\PendientesController::class, 'index']
)->name('pendientes');

Route::post('/changeTeam', [\App\Http\Controllers\PendientesController::class, 'changeTeam'])->name('changeTeam');

Route::resource('points',\App\Http\Controllers\PointController::class);
Route::resource('period',\App\Http\Controllers\PeriodController::class);
Route::post('addPoints', [\App\Http\Controllers\PointController::class, 'addPointsToUser'])->name('addPoints');
Route::get('endPeriod', [\App\Http\Controllers\PeriodController::class, 'endPeriod'])->name('endPeriod');
