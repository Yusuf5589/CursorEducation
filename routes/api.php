<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/get', [UserController::class, "all"]);
Route::get('/get/{id}', [UserController::class, "find"]);
Route::post('/create', [UserController::class, "create"]);
Route::put('/update/{id}', [UserController::class, "update"]);
Route::delete('/delete/{id}', [UserController::class, "delete"]);