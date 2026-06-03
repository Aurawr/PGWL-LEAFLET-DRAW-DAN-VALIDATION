<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolylinesController;
use App\Http\Controllers\PolygonsController;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

Route::get('/', [PagesController::class, 'landingpage'])->name('home');

Route::get('/map', [PagesController::class, 'map'])
->middleware(['auth', 'verified'])
->name('map');

// Route::get('/map', [PagesController::class, 'map'])->name('map');

Route::get('/table', [PagesController::class, 'table'])->name('table');

//Point
Route::post('/store-points', [PointsController::class, 'store'])->name('points.store');
//Route hapus data point
Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])->name('points.delete');
// Route edit data point
Route::get('/edit-point/{id}', [PointsController::class, 'edit'])->name('point.edit');
// Route update data point
Route::patch('/update-point/{id}', [PointsController::class, 'update'])->name('point.update');

//Polylines
Route::post('/store-polylines', [PolylinesController::class, 'store'])->name('polylines.store');
Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])->name('polylines.delete');
// Route edit data polyline
Route::get('/edit-polyline/{id}', [PolylinesController::class, 'edit'])->name('polyline.edit');
// Route update data polyline
Route::patch('/update-polyline/{id}', [PolylinesController::class, 'update'])->name('polyline.update');

//Polygons
Route::post('/store-polygons', [PolygonsController::class, 'store'])->name('polygons.store');
Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])->name('polygons.delete');
// Route edit data polygon
Route::get('/edit-polygon/{id}', [PolygonsController::class, 'edit'])->name('polygon.edit');
// Route update data polygon
Route::patch('/update-polygon/{id}', [PolygonsController::class, 'update'])->name('polygon.update');


Route::view('dashboard', 'dashboard')
->middleware(['auth', 'verified'])
->name('dashboard');


require __DIR__.'/settings.php';
