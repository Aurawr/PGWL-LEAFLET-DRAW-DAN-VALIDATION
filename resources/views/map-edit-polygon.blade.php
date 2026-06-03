@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>

    <style>
        body, html{
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }
    </style>
@endsection

@section('content')
    <!-- Map Container -->
    <div id="map"></div>

        {{-- Modal Form Edit --}}
    <div class="modal" tabindex="-1" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">EDIT DATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygon.update', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Fill Name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry" name="geometry" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image"
                                onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">

                                <img src="" alt="" id="preview-image" class="img-thumbnail" width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://unpkg.com/@terraformer/wkt"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // initialize the map and set its view to a default location
    var map = L.map('map').setView([-6.200000, 106.816666], 10); // Jakarta coordinates example

    // add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    /* Digitize Function */
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
	    draw: false,
	    edit: {
            featureGroup: drawnItems,
		    edit: true,
		    remove: false
        }
    });

    map.addControl(drawControl);

    map.on('draw:edited', function(e) {
	var layers = e.layers;

	    layers.eachLayer(function(layer) {
		    var drawnJSONObject = layer.toGeoJSON();
		    console.log(drawnJSONObject);

		    var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
		    console.log(objectGeometry);

		    // layer properties
		    var properties = drawnJSONObject.properties;
		    console.log(properties);

		    drawnItems.addLayer(layer);

            // mengisi form modal dengan data yang sudah ada
            $('#name').val(properties.name);
            $('#description').val(properties.description);
            $('#geometry').val(objectGeometry);
            $('#preview-image').attr('src', "{{asset('storage/images')}}/" + properties.image); // pastikan properties.image_url berisi URL gambar yang benar

            // menampilknan modal edit
            $('#modalEdit').modal('show');
	    });
    });

    //Polygons Layer
    var polygons = L.geoJSON(null, {
        // Style

        // onEachFeature
        onEachFeature: function (feature, layer) {

            // memasukkan layer ke dalam drawnItems agar bisa diedit
            drawnItems.addLayer(layer);

            var objectGeometry = Terraformer.geojsonToWKT(feature.geometry);
            var properties = feature.properties;

            layer.on({
                click: function (e) {
                    // mengisi form modal dengan data yang sudah ada
                    $('#name').val(properties.name);
                    $('#description').val(properties.description);
                    $('#geometry').val(objectGeometry);
                    $('#preview-image').attr('src', "{{asset('storage/images')}}/" + properties.image); // pastikan properties.image_url berisi URL gambar yang benar
                    // menampilknan modal edit
                    $('#modalEdit').modal('show');
                },
            });
        }

    });

    $.getJSON("{{ route('polygon.geojson', $id) }}", function (data) {
	polygons.addData(data); // Menambahkan data ke dalam GeoJSON Polygon Sarana Prasarana
	map.addLayer(polygons); // Menambahkan GeoJSON Polygon Sarana Prasarana ke dalam peta
    });
    </script>
@endsection
