<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\NewspaperController;
use App\Http\Controllers\CdController;
use Inertia\Inertia;
use App\Http\Controllers\RolePermissionController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

// Books Routes (Using resource controller with role-based middleware)
Route::resource('/books', BookController::class);

// Apply Role Middleware to approve/reject actions for admins
Route::middleware(['role:admin'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::patch('/books/{book}/approve', [BookController::class, 'approve'])->name('books.approve');
    Route::patch('/books/{book}/reject', [BookController::class, 'reject'])->name('books.reject');
});

// Librarian Routes (Role-based CRUD for books)
Route::middleware(['role:librarian'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// General Book Routes (viewing and accessing specific books for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});

// Journals Routes
Route::resource('/journals', JournalController::class);
Route::post('/journals/{id}/request', [JournalController::class, 'requestAccess'])->name('journals.request');
Route::post('/journals/{id}/grant', [JournalController::class, 'grantAccess'])->name('journals.grant');

// Newspapers Routes
Route::resource('newspapers', NewspaperController::class);
Route::post('newspapers/{id}/mark-as-stored', [NewspaperController::class, 'markAsStored'])->name('newspapers.markAsStored');

// CDs Routes
Route::resource('cds', CdController::class);

// Role and Permission Controller (for admin role and permission creation)
Route::get('/create-roles-permissions', [RolePermissionController::class, 'createRolesAndPermissions']);

// Admin Routes for roles (directly applying role middleware for the admin page)
Route::get('/admin', function () {
    // Admin page logic here...
})->middleware(RoleMiddleware::class . ':admin'); 

// Librarian Approve Reservation (Using permission middleware)
Route::middleware(['permission:approve book reservation'])->get('/librarian/approve-reservation', function () {
    return view('librarian.approve');
});
