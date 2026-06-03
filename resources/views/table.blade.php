@extends('layouts.template')

@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
@endsection

@section('content')
<div class="container mt-3">
<div class="card">
    <div class="card-header">
        <h3>Tabel Data Points</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="tabeldata">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($points as $p)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p['name'] }}</td>
                        <td>{{ $p['description'] }}</td>
                        <td>
                            <img src="{{ asset('storage/images').'/'.$p['image'] }}"
                            alt="" width="150">
                        </td>
                        <td>{{ $p['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="container mt-3">
<div class="card">
    <div class="card-header">
        <h3>Tabel Data Polylines</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="tabeldatapolyline">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($polylines as $pl)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pl['name'] }}</td>
                        <td>{{ $pl['description'] }}</td>
                        <td>
                            <img src="{{ asset('storage/images').'/'.$pl['image'] }}"
                            alt="" width="150">
                        </td>
                        <td>{{ $pl['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="container mt-3">
<div class="card">
    <div class="card-header">
        <h3>Tabel Data Polygons</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="tabeldatapolygon">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($polygons as $pg)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pg['name'] }}</td>
                        <td>{{ $pg['description'] }}</td>
                        <td>
                            <img src="{{ asset('storage/images').'/'.$pg['image'] }}"
                            alt="" width="150">
                        </td>
                        <td>{{ $pg['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="//cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script>
    new DataTable('#tabeldata');
    new DataTable('#tabeldatapolyline');
    new DataTable('#tabeldatapolygon');
</script>
@endsection
