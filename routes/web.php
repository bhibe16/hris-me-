<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\Admin\ProfilePictureController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Employee\EducationalHistoryController;
use App\Http\Controllers\Api\EmployeeAPIController;
use App\Http\Controllers\Employee\DocumentController as EmployeeDocumentController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/register', [ProfileController::class, 'create'])->name('register');
});

// Admin Dashboard Route
Route::middleware(['auth', 'admin', 'employee.status'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/index', [EmployeeAPIController::class, 'index'])->name('admin.index');
});

// Employee Dashboard Route
Route::middleware(['auth', 'employee', 'employee.status'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

// Admin Employee Management Routes
Route::middleware(['auth', 'admin', 'employee.status'])->group(function () {
    Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::delete('/admin/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/admin/employees/archived', [EmployeeController::class, 'archived'])->name('admin.employees.archived');
    Route::post('/employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::put('/employees/{id}/update-status', [EmployeeController::class, 'updateStatus'])->name('employees.updateStatus');
});

// Employee Records Routes
Route::middleware(['auth', 'employee', 'employee.status'])->group(function () {
    Route::get('/employee/records', [\App\Http\Controllers\Employee\RecordController::class, 'index'])->name('employee.records.index');
    Route::get('/employee/records/create', [\App\Http\Controllers\Employee\RecordController::class, 'create'])->name('employee.records.create');
    Route::post('/employee/records', [\App\Http\Controllers\Employee\RecordController::class, 'store'])->name('employee.records.store');
    Route::get('/employee/records/{id}/edit', [\App\Http\Controllers\Employee\RecordController::class, 'edit'])->name('employee.records.edit');
    Route::put('/employee/records/{id}', [\App\Http\Controllers\Employee\RecordController::class, 'update'])->name('employee.records.update');
    Route::delete('/employee/records/{id}', [\App\Http\Controllers\Employee\RecordController::class, 'destroy'])->name('employee.records.destroy');

    // Educational History
    Route::get('employee/educational-history/create', [EducationalHistoryController::class, 'createEducation'])->name('employee.educational-history.create');
    Route::post('employee/educational-history/store', [EducationalHistoryController::class, 'storeEducation'])->name('employee.educational-history.store');
    Route::get('employee/educational-history/{id}/edit', [EducationalHistoryController::class, 'editEducation'])->name('employee.educational-history.edit');
    Route::put('employee/educational-history/{id}', [EducationalHistoryController::class, 'updateEducation'])->name('employee.educational-history.update');
    Route::delete('employee/educational-history/{id}', [EducationalHistoryController::class, 'destroyEducation'])->name('employee.educational-history.destroy');
});

// Employment History (Admin)
Route::middleware(['auth', 'admin', 'employee.status'])->group(function () {
    Route::get('/admin/employment', [\App\Http\Controllers\Admin\EmploymentController::class, 'index'])->name('admin.employment.index');
    Route::get('/employment-history', [\App\Http\Controllers\Admin\EmploymentController::class, 'showHistory']);
});

// Employment History (Employee)
Route::middleware(['auth', 'employee', 'employee.status'])->group(function () {
    Route::get('/employee/history', [\App\Http\Controllers\Employee\HistoryController::class, 'index'])->name('employee.history.index');
    Route::get('/employee/history/create', [\App\Http\Controllers\Employee\HistoryController::class, 'create'])->name('employee.history.create');
    Route::post('/employee/history', [\App\Http\Controllers\Employee\HistoryController::class, 'store'])->name('employee.history.store');
    Route::get('/employee/history/{id}/edit', [\App\Http\Controllers\Employee\HistoryController::class, 'edit'])->name('employee.history.edit');
    Route::put('/employee/history/{id}', [\App\Http\Controllers\Employee\HistoryController::class, 'update'])->name('employee.history.update');
    Route::delete('/employee/history/{id}', [\App\Http\Controllers\Employee\HistoryController::class, 'destroy'])->name('employee.history.destroy');
});

// Employee Dashboard with Multiple Data Sources
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/employee/records', function () {
        $historyController = new \App\Http\Controllers\Employee\HistoryController();
        $recordController = new \App\Http\Controllers\Employee\RecordController();
        $educationController = new \App\Http\Controllers\Employee\EducationalHistoryController();

        return view('employee.records.index', [
            'history' => $historyController->index()->getData()['history'],
            'record' => $recordController->index()->getData()['record'],
            'educationalHistory' => $educationController->index()->getData()['educationalHistory']
        ]);
    })->name('employee.records.index');
});

// Employee Document Routes
Route::middleware(['auth', 'employee', 'employee.status'])->group(function () {
    Route::get('/documents/upload', [EmployeeDocumentController::class, 'showForm'])->name('employee.documents.upload');
    Route::post('/documents', [EmployeeDocumentController::class, 'store'])->name('employee.documents.store');
    Route::get('/documents', [EmployeeDocumentController::class, 'index'])->name('employee.documents.index');
});

// Admin Document Routes
Route::middleware(['auth', 'admin', 'employee.status'])->group(function () {
    Route::get('/admin/documents', [AdminDocumentController::class, 'index'])->name('admin.documents.index');
    Route::post('/admin/documents/{document}/review', [AdminDocumentController::class, 'review'])->name('admin.documents.review');
    Route::get('/admin/documents/{document}/view', [AdminDocumentController::class, 'viewDocument'])->name('admin.documents.view');
});

// Profile Picture Upload
Route::middleware(['auth', 'employee.status'])->group(function () {
    Route::post('/employee/{id}/profile-picture', [ProfilePictureController::class, 'upload'])->name('employee.profile_picture.upload');
    Route::delete('/employee/{id}/profile-picture', [ProfilePictureController::class, 'delete'])->name('employee.profile_picture.delete');
});

// Notifications
Route::middleware(['auth', 'employee.status'])->group(function () {
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
    Route::post('/admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllRead');
    Route::post('/admin/notifications/delete-selected', [NotificationController::class, 'deleteSelected'])->name('admin.notifications.deleteSelected');
    Route::post('/notifications/{id}/mark-as-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    });
});

// Loading page route
Route::get('/loading', function () {
    return view('loading');
})->name('loading');

Route::patch('/employees/{employee}/update-status', [EmployeeController::class, 'updateStatus'])
    ->name('employees.update-status');

require __DIR__.'/auth.php';
