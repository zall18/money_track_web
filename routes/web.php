<?php

use App\Http\Controllers\FlowcashController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('main-view.dashboard');
});

Route::get('/flowcash', [FlowcashController::class, 'index'])->name('flowcash.index');
Route::post('/flowcash/create', [FlowcashController::class, 'store'])->name('flowcash.store');
Route::put('/flowcash/{id}', [FlowcashController::class, 'update'])->name('flowcash.update');