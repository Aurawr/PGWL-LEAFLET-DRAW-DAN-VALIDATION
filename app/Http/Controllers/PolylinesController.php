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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry_polyline.required' => 'Geometry polyline is required.',
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
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
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
        $data = [
                'title' => 'Edit Polyline',
                'id' => $id,
                ];
        return view('map-edit-polyline',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'geometry' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry.required' => 'Geometry polyline is required.',
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

        $image_old = $this->polylines->find($id)->image;

        // Get upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);

            //Hapus file gambar jika ada
            if ($image_old != null) {
                if (file_exists('./storage/images/' . $image_old)) {
                    unlink('./storage/images/' . $image_old);
                }
            }
        } else {
            $name_image = $image_old;
        }
        
        $data = [
            'geom' => $request->geometry,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // Simpan data ke database
        if (!$this->polylines->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Failed to update polyline.');
        }
        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Polyline updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Memcari nama file gambar berdasarkan id polyline
        $image = $this->polylines->find($id)->value('image');
         // Hapus data ke database
        if(!$this->polylines->destroy($id)) {
            return redirect()->route('map')->with('error', 'Failed to delete polyline.');
        }

        //Hapus file gambar jika ada
        if ($image != null) {
            if (file_exists('./storage/images/' . $image)) {
                unlink('./storage/images/' . $image);
            }
        }

        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Polyline deleted successfully.');
    }
}
