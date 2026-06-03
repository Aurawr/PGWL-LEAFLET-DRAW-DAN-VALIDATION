<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use App\Models\polylinesModel;
use App\Models\polygonsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PagesController extends Controller
{
     public function __construct()
    {
        $this->points = new pointsModel();
        $this->polylines = new polylinesModel();
        $this->polygons = new polygonsModel();
    }
    public function map()
    {
        $data = [
           'title' => 'Peta Interaktif',
        ];
        return view('map',$data);
    }

    public function table()
    {
        $data = [
           'title' => 'Tabel',
           'points' => $this->points->all(),
            'polylines' => $this->polylines->all(),
            'polygons' => $this->polygons->all(),
        ];
        return view('table',$data);
    }
    public function landingpage()
    {
        $data = [
           'title' => 'PGWL',
           'points_count' => $this->points->count(),
           'polylines_count' => $this->polylines->count(),
           'polygons_count' => $this->polygons->count(),
        ];
        return view('home',$data);
    }
}
