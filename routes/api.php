<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Grouped routes
Route::group([
    'prefix' => 'user',
    'as' => 'user.',
], function () {
    Route::post('/getUserList', [UserController::class, 'getUserList']);
    Route::post('/createUser', [UserController::class, 'store']);
    Route::put('/updateUser/{user}', [UserController::class, 'update']);
    Route::delete('/deleteUser/{user}', [UserController::class, 'destroy']);
});

