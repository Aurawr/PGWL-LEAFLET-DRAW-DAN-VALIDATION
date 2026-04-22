<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Termwind\Components\Raw;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//GeoJSON API
Route::get('/points', [ApiController::class, 'geojson_points'])
->name('points.geojson');

Route::get('/polylines', [ApiController::class, 'geojson_polylines'])
->name('polylines.geojson');

Route::get('/polygons', [ApiController::class, 'geojson_polygons'])
->name('polygons.geojson');
