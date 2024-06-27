<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [TaskController::class, "index"])->name('task.index');



Route::get('students', [TaskController::class, 'index']);
Route::post('students', [TaskController::class, 'store']);
Route::get('fetch-students', [TaskController::class, 'fetchstudent']);
Route::get('edit-student/{id}', [TaskController::class, 'edit']);
Route::put('update-student/{id}', [TaskController::class, 'update']);
Route::delete('delete-student/{id}', [TaskController::class, 'destroy']);
Route::get('status-change/{id}', [TaskController::class, 'status']);

