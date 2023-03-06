<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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


Route::get('/tasks', [TaskController::class, 'index'])->name('api/tasks/index');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('api/tasks/show');
Route::post('/tasks', [TaskController::class, 'store'])->name('api/tasks/store');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('api/tasks/update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('api/tasks/destroy');
