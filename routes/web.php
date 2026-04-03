<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;

// Homepage - all provinces
Route::get('/', [WilayahController::class, 'index'])->name('home');

// Province detail - show kabupaten
Route::get('/provinsi/{provinsi}', [WilayahController::class, 'provinsi'])->name('provinsi');

// Kabupaten detail - show kecamatan
Route::get('/provinsi/{provinsi}/{kabupaten}', [WilayahController::class, 'kabupaten'])->name('kabupaten');

// Kecamatan detail - show schools with map
Route::get('/provinsi/{provinsi}/{kabupaten}/{kecamatan}', [WilayahController::class, 'kecamatan'])->name('kecamatan');

// School detail page
Route::get('/sekolah/{npsn}', [WilayahController::class, 'sekolah'])->name('sekolah');

// Search API
Route::get('/api/search', [WilayahController::class, 'search'])->name('api.search');

// Sitemap
Route::get('/sitemap.xml', [WilayahController::class, 'sitemap'])->name('sitemap');
