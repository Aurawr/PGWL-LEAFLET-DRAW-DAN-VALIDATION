<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function map()
    {
        $data = [
           'title' => 'Peta',
        ];
        return view('map',$data);
    }

    public function table()
    {
        $data = [
           'title' => 'Tabel',
        ];
        return view('table',$data);
    }
}
