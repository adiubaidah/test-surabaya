<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\NilaiController;

Route::post('/login', [AuthController::class, 'login']);

// Soal Bonus SQL
Route::get('/nilaiRT', [NilaiController::class, 'RT']);
Route::get('/nilaiST', [NilaiController::class, 'ST']);

Route::middleware(['jwt'])->group(function(){
    Route::controller(DivisionController::class)->group(function(){
        Route::get('/divisions', 'get');
    });
    Route::controller(EmployeeController::class)->group(function(){
        Route::get('/employees', 'index');
        Route::post('/employees', 'store');
        Route::put('/employees/{id}', 'update');
        Route::delete('/employees/{id}', 'destroy');
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
