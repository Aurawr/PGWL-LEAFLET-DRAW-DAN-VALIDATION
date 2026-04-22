@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>

    <style>
        body{
            margin: 0;
            padding: 0;
        }
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    <!-- Map Container -->
    <div id="map"></div>

        {{-- Modal Form Input Untuk Point --}}
    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CREATE POINT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('points.store') }}" method="POST">
                    @csrf
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
                            <label for="geometry_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3"></textarea>
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

    {{-- Modal Form Input Polylines --}}
    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CREATE POLYLINE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polylines.store') }}" method="POST">
                    @csrf
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
                            <label for="geometry_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3"></textarea>
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

    {{-- Modal Form Input Polygons --}}
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CREATE POLYGON</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygons.store') }}" method="POST">
                    @csrf
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
                            <label for="geometry_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3"></textarea>
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
        maxZoom: 11,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    /* Digitize Function */
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
	    draw: {
		    position: 'topleft',
		    polyline: true,
		    polygon: true,
            rectangle: true,
            circle: false,
            marker: true,
            circlemarker: false
	    },
	    edit: false
    });

    map.addControl(drawControl);

    map.on('draw:created', function(e) {
	    var type = e.layerType,
		    layer = e.layer;

	    console.log(type);

	    var drawnJSONObject = layer.toGeoJSON();
	    var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

	    console.log(drawnJSONObject);
	    console.log(objectGeometry);

	    if (type === 'polyline') {
		    console.log("Create " + type);
            // Set value geometry to textarea
                $('#geometry_polyline').val(objectGeometry);
                //Show Modal Input Point
                $("#modalInputPolyline").modal('show');
                // Modal Dismiss Event
                $('#modalInputPolyline').on('hidden.bs.modal', function () {
                    location.reload();
                });
	    } else if (type === 'polygon' || type === 'rectangle') {
		    console.log("Create " + type);
            // Set value geometry to textarea
                $('#geometry_polygon').val(objectGeometry);
                //Show Modal Input Point
                $("#modalInputPolygon").modal('show');
                // Modal Dismiss Event
                $('#modalInputPolygon').on('hidden.bs.modal', function () {
                    location.reload();
                });
	    } else if (type === 'marker') {
		    console.log("Create " + type);
            // Set value geometry to textarea
            $('#geometry_point').val(objectGeometry);
            //Show Modal Input Point
            $("#modalInputPoint").modal('show');
            // Modal Dismiss Event
            $('#modalInputPoint').on('hidden.bs.modal', function () {
                location.reload();
            });
	    } else {
		    console.log('__undefined__');
	    }

	    drawnItems.addLayer(layer);
    });

    //Point Layer
    var points = L.geoJSON(null, {
	// Style

	// onEachFeature
     onEachFeature: function (feature, layer) {
	// variable popup content
	    var popup_content = "Nama: " + feature.properties.name + "<br>" +
		"Deskripsi: " + feature.properties.description + "<br>" +
        "Dibuat: " + feature.properties.created_at;

	    layer.on({
		    click: function (e) {
			    points.bindPopup(popup_content);
		    },
	    });
    }

    });

    $.getJSON("{{ route('points.geojson') }}", function (data) {
	points.addData(data); // Menambahkan data ke dalam GeoJSON Point Sarana Prasarana
	map.addLayer(points); // Menambahkan GeoJSON Point Sarana Prasarana ke dalam peta
    });

    //Polylines Layer
    var polylines = L.geoJSON(null, {
	// Style

	// onEachFeature
     onEachFeature: function (feature, layer) {
	// variable popup content
	    var popup_content = "Nama: " + feature.properties.name + "<br>" +
		"Deskripsi: " + feature.properties.description + "<br>" +
        "Dibuat: " + feature.properties.created_at;

	    layer.on({
		    click: function (e) {
			    polylines.bindPopup(popup_content);
		    },
	    });
    }

    });

    $.getJSON("{{ route('polylines.geojson') }}", function (data) {
	polylines.addData(data); // Menambahkan data ke dalam GeoJSON Polyline
	map.addLayer(polylines); // Menambahkan GeoJSON Polyline ke dalam peta
    });

    //Polygons Layer
    var polygons = L.geoJSON(null, {
	// Style

	// onEachFeature
     onEachFeature: function (feature, layer) {
	// variable popup content
	    var popup_content = "Nama: " + feature.properties.name + "<br>" +
		"Deskripsi: " + feature.properties.description + "<br>" +
        "Dibuat: " + feature.properties.created_at;

	    layer.on({
		    click: function (e) {
			    polygons.bindPopup(popup_content);
		    },
	    });
    }

    });

    $.getJSON("{{ route('polygons.geojson') }}", function (data) {
	polygons.addData(data); // Menambahkan data ke dalam GeoJSON Polygon
	map.addLayer(polygons); // Menambahkan GeoJSON Polygon ke dalam peta
    });

    // Layer Control
    var baseMaps = {

    };

    var overlayMaps = {
	    "Marker": points,
	    "Polyline": polylines,
	    "Polygon": polygons,
    };

    var controllayer = L.control.layers(baseMaps, overlayMaps);
    controllayer.addTo(map);
    </script>
@endsection
