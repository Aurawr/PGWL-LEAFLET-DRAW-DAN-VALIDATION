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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry_polygon.required' => 'Geometry polygon is required.',
            'name.required' => 'Name is required.',
            'description.required' => 'Description is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
        ]);

        // Create directory for storing images if it doesn't exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
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
