<?php

use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthLoginController::class, 'login'])->name('form.login')->middleware('web');;


Route::prefix('tareas')->group(function () {
    Route::get('/', [TareaController::class, 'index']);
    Route::post('/', [TareaController::class, 'create'])->name('crear.tarea');
    Route::put('/', [TareaController::class, 'estado']);
    Route::put('/{id}', [TareaController::class, 'update']);
    Route::delete('/{id}', [TareaController::class, 'destroy']);
    Route::get('/{id}', [TareaController::class, 'show']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'create']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::delete('/login', [UserController::class, 'login']);
});


