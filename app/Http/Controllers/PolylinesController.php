<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    protected $polylines;
     public function __construct()
    {
        $this->polylines=new polylinesModel();
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
            'geometry_polyline' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ],
        [
            'geometry_polyline.required' => 'Geometry polyline is required.',
            'name.required' => 'Name is required.',
            'description.required' => 'Description is required.',
        ]);
        
       $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Simpan data ke database
        if (!$this->polylines->create($data)) {
            return redirect()->route('map')->with('error', 'Failed to create polyline.');
        }
        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Polyline created successfully.');
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
