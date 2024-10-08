<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AuthController;



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk admin (CRUD playlist)
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [PlaylistController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::resource('playlists', PlaylistController::class);
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::post('/playlists/{id}/add-song', [PlaylistController::class, 'addSong'])->name('playlists.addSong');
    Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::post('/playlists/{id}/delete-song', [PlaylistController::class, 'deleteSong'])->name('playlists.deleteSong');
});

// Route untuk user (melihat dan memutar playlist)
Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/playlists', [PlaylistController::class, 'userPlaylists'])->name('user.playlists');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
});
