<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDataBukuController;
use App\Http\Controllers\DashboardPeminjamanBukuController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/buku', [HomeController::class, 'book'])->name('book.index');
Route::post('/buku', [HomeController::class, 'borrowBook'])->name('book.pinjam');
Route::get('/buku/{book:slug}', [HomeController::class, 'bookDetail'])->name('book.detail');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/peminjaman-buku', [DashboardPeminjamanBukuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard-peminjaman-buku.index');
Route::post('/dashboard/peminjaman-buku', [DashboardPeminjamanBukuController::class, 'pengambilan'])->middleware(['auth', 'verified'])->name('dashboard-peminjaman-buku.pengambilan');
Route::post('/dashboard/peminjaman-buku/pengembalian', [DashboardPeminjamanBukuController::class, 'pengembalian'])->middleware(['auth', 'verified'])->name('dashboard-peminjaman-buku.pengembalian');
Route::resource('/dashboard/mahasiswa', DashboardMahasiswaController::class)
->name('index', 'dashboard-mahasiswa.index')
->name('create', 'dashboard-mahasiswa.create')
->name('store', 'dashboard-mahasiswa.store')
->name('edit', 'dashboard-mahasiswa.edit')
->name('update', 'dashboard-mahasiswa.update')
->name('destroy', 'dashboard-mahasiswa.destroy')
;
Route::resource('/dashboard/data-buku', DashboardDataBukuController::class)
->name('index', 'dashboard-data-buku.index')
->name('create', 'dashboard-data-buku.create')
->name('store', 'dashboard-data-buku.store')
->name('edit', 'dashboard-data-buku.edit')
->name('update', 'dashboard-data-buku.update')
->name('destroy', 'dashboard-data-buku.destroy')
;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
