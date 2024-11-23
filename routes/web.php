<?php

use App\Http\Controllers\privatskolotajiController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/privatskolotaji', [App\Http\Controllers\privatskolotajiController::class, 'index'])->name('privatskolotaji');
Route::get('/sadarbiba', [App\Http\Controllers\privatskolotajiController::class, 'sadarbiba'])->name('sadarbiba');
Route::get('/exam', [App\Http\Controllers\eksamensController::class, 'index'])->name('exam');