<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Public welcome route
Route::get('/', function () {
    return view('welcome');
});

// Redirect /dashboard to the admin dashboard controller (fixes undefined variable error)
Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect /admin to /admin/admin/dashboard
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/admin/dashboard');
    });

    // Admin dashboard (loads data properly)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // File Manager routes
    Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');
    Route::get('/filemanager/create', [FileManagerController::class, 'create'])->name('filemanager.create');
    Route::post('/filemanager', [FileManagerController::class, 'store'])->name('filemanager.store');
    Route::get('/filemanager/{filename}', [FileManagerController::class, 'show'])->name('filemanager.show');
    Route::get('/filemanager/{filename}/edit', [FileManagerController::class, 'edit'])->name('filemanager.edit');
    Route::put('/filemanager/{filename}', [FileManagerController::class, 'update'])->name('filemanager.update');
    Route::delete('/filemanager/{filename}', [FileManagerController::class, 'destroy'])->name('filemanager.destroy');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Content management
    Route::resource('contents', ContentController::class);

    // Admin-specific content routes
    Route::get('/admin-contents', [AdminController::class, 'adminContents'])->name('admin.adminContents');
    Route::get('/admin-contents/create', [AdminController::class, 'createAdminContent'])->name('admin.adminContents.create');
    Route::post('/admin-contents', [AdminController::class, 'storeAdminContent'])->name('admin.adminContents.store');
    Route::get('/admin-contents/{id}/edit', [AdminController::class, 'editAdminContent'])->name('admin.adminContents.edit');
    Route::put('/admin-contents/{id}', [AdminController::class, 'updateAdminContent'])->name('admin.adminContents.update');
    Route::delete('/admin-contents/{id}', [AdminController::class, 'deleteAdminContent'])->name('admin.adminContents.delete');
});

// Auth scaffolding (Login/Register)
require __DIR__ . '/auth.php';

// Optional: Assign Super Admin role
Route::get('/assign-superadmin', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    $user->role = 'super_admin';
    $user->save();
    return "Your role has been updated to super_admin. You can now access the admin panel.";
});

// Test route for super admin
Route::middleware(['auth', 'superadmin'])->get('/admin/test', function () {
    return "You are a super admin!";
});
