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
});

