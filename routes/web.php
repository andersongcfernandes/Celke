<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EnviarSmsController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('importararquivo', [UserController::class, 'importararquivo'])->name('user.index');

Route::get('enviarsms',[EnviarSmsController::class, 'enviarSms'])->name('enviarsms');

Route::post('users-import',[UserController::class, 'import'])->name('user.import');
