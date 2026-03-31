<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    protected $polygons;
    public function __construct() // Constructor untuk koneksi model ke controller
    {
        $this->polygons=new polygonsModel();
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'geometry_polygon' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ],
        [
            'geometry_polygon.required' => 'Geometry polygon is required.',
            'name.required' => 'Name is required.',
            'description.required' => 'Description is required.',
        ]);
        
        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Simpan data ke database
        if (!$this->polygons->create($data)) {
            return redirect()->route('map')->with('error', 'Failed to create polygon.');
        }
        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Polygon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
