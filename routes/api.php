<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Termwind\Components\Raw;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//GeoJSON API
// POINTS
Route::get('/points', [ApiController::class, 'geojson_points'])
->name('points.geojson');

Route::get('/point/{id}', [ApiController::class, 'geojson_point'])
->name('point.geojson');

// POLYLINES
Route::get('/polylines', [ApiController::class, 'geojson_polylines'])
->name('polylines.geojson');

Route::get('/polyline/{id}', [ApiController::class, 'geojson_polyline'])
->name('polyline.geojson');

// POLYGONS
Route::get('/polygons', [ApiController::class, 'geojson_polygons'])
->name('polygons.geojson');

Route::get('/polygon/{id}', [ApiController::class, 'geojson_polygon'])
->name('polygon.geojson');
