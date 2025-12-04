<?php

use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('rooms', RoomController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('users', UserController::class);
