@extends('layouts.template')
<style>
    .home-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        background: #ffffff;
    }

    /* .home-card-header {
        background: #110267;
        border-bottom: none;
        padding: 1.75rem 1.75rem 1.25rem;
    } */

    .home-card-title {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #fcfdff;
        letter-spacing: 0.02em;
        margin: 0;
    }

    .counts {
        font-family: 'Inter', 'ui-sans-serif', system-ui, sans-serif;
        color: #fcfdff;
        font-size: 2.5rem;
        line-height: 1.8;
        margin: 0;
    }

    .home-card-text {
        font-family: 'Inter', 'ui-sans-serif', system-ui, sans-serif;
        color: #525f7f;
        font-size: 1rem;
        line-height: 1.8;
        margin: 0;
    }
</style>

@section('content')
    <div class="container mt-5">
        <div class="card home-card mb-4">
            <div class="card-header" style="background-color: #281C59;">
                <h3 class="home-card-title">Welcome Home, Rara!</h3>
            </div>
            <div class="card-body px-4 pb-4">
                <p class="home-card-text">
                    Aplikasi ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Web Lanjut.
                    Aplikasi ini menampilkan peta interaktif yang menunjukkan objek-objek geometri titik, garis,
                    dan poligon yang diambil dari database PostGIS. Aplikasi ini menggunakan Leaflet draw untuk
                    memungkinkan pengguna menggambar objek geometri baru pada peta, yang kemudian disimpan
                    ke dalam database PostGIS.
                </p>
            </div>
        </div>
    <div class="row">
        <div class="col-3">
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Jumlah Point</h3>
                </div>
                <div class="card-body text-center" style="background-color: #281C59;">
                    <h1 class="counts">{{ $points_count }}</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Jumlah Polyline</h3>
                </div>
                <div class="card-body text-center"  style="background-color: #281C59;">
                    <h1 class="counts"> {{ $polylines_count }}</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Jumlah Polygon</h3>
                </div>
                <div class="card-body text-center"  style="background-color: #281C59;">
                    <h1 class="counts">{{ $polygons_count }}</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Jumlah User</h3>
                </div>
                <div class="card-body text-center"  style="background-color: #281C59;">
                    <h1 class="counts">5</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
