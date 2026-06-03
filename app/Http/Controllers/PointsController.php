<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    protected $points;

    public function __construct()
    {
        $this->points=new pointsModel();
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
        // Validasi input
        $request->validate([
            'geometry_point' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry_point.required' => 'Geometry point is required.',
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
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // Simpan data ke database
        if(!$this->points->create($data)) {
            return redirect()->route('map')->with('error', 'Failed to create point.');
        }

        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Point created successfully.');
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
                'title' => 'Edit Point',
                'id' => $id,
                ];
        return view('map-edit-point',$data);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, string $id)
    {
    // Validasi input
        $request->validate([
            'geometry' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],
        [
            'geometry.required' => 'Geometry point is required.',
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

        $image_old = $this->points->find($id)->image;

        // Get upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
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
        if(!$this->points->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Failed to update point.');
        }

            // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Point updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Memcari nama file gambar berdasarkan id point
        $image = $this->points->find($id)->value('image');
         // Hapus data ke database
        if(!$this->points->destroy($id)) {
            return redirect()->route('map')->with('error', 'Failed to delete point.');
        }

        //Hapus file gambar jika ada
        if ($image != null) {
            if (file_exists('./storage/images/' . $image)) {
                unlink('./storage/images/' . $image);
            }
        }

        // Kembali ke halaman peta
        return redirect()->route('map')->with('success', 'Point deleted successfully.');
    }
}
