<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;


Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show'); 
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
Route::resource('playlists', PlaylistController::class);
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::post('/playlists/{id}/add-song', [PlaylistController::class, 'addSong'])->name('playlists.addSong');
Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
Route::post('/playlists/{id}/delete-song', [PlaylistController::class, 'deleteSong'])->name('playlists.deleteSong');

});

