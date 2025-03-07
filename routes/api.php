<?php

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

use App\Http\Controllers\Admin\EmployeeController;


// API Employee Records with Authentication and Employee Status Check
Route::middleware(['auth:sanctum', 'admin', 'employee.status'])->group(function () {
    Route::get('/admin/employees', [EmployeeController::class, 'apiIndex'])->name('api.admin.employees.index');
});

use App\Http\Controllers\Admin\DocumentController;

Route::get('/documents', [DocumentController::class, 'apiIndex'])->name('api.documents.index');


Route::get('/employees', [EmployeeController::class, 'apiIndex'])->name('api.employees.index');

use App\Http\Controllers\UserSyncController;

Route::get('/sync-users', [UserSyncController::class, 'syncUsers'])->name('api.sync-users');



