<?php

use App\Http\Controllers\API\WordGetController;
use App\Http\Controllers\API\WordStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/words', WordStoreController::class)->name('words.store.translate.invokable');
Route::get('/words', WordGetController::class)->name('words.get.translate.invokable');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

