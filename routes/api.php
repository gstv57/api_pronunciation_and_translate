<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WordController;

Route::post('/words', WordController::class)->name('words.translate.invokable');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

