<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class polylinesModel extends Model
{
    protected $table = 'polylines';
    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        $polylines = $this->select(DB::raw('id, ST_AsGeoJSON(geom) as geojson, name,
        description, image, created_at, updated_at'))->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        //Perulangan setiap titik untuk membuat fitur GeoJSON
        foreach ($polylines as $pl) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($pl->geojson),
                'properties' => [
                    'id' => $pl->id,
                    'name' => $pl->name,
                    'description' => $pl->description,
                    'image' => $pl->image,
                    'created_at' => $pl->created_at,
                    'updated_at' => $pl->updated_at,
                ]
            ];
            array_push($geojson['features'], $feature);
    }
    return $geojson;
    }
}
