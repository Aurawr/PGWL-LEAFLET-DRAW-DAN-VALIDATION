<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class polygonsModel extends Model
{
    protected $table = 'polygons';
    protected $guarded = ['id'];

    public function geojson_polygons()
    {
        $polygons = $this->select(DB::raw('id, ST_AsGeoJSON(geom) as geojson, name,
        description, image, created_at, updated_at'))->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        //Perulangan setiap titik untuk membuat fitur GeoJSON
        foreach ($polygons as $pg) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($pg->geojson),
                'properties' => [
                    'id' => $pg->id,
                    'name' => $pg->name,
                    'description' => $pg->description,
                    'image' => $pg->image,
                    'created_at' => $pg->created_at,
                    'updated_at' => $pg->updated_at,
                ]
            ];
            array_push($geojson['features'], $feature);
    }
    return $geojson;
    }
}
