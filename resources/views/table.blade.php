@extends('layouts.template')

@section('content')
<div class="container mt-3">
<div class="card">
    <div class="card-header">
        <h3>Tabel Data</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Klein Moretti</td>
                    <td>15 Minsk Street, Tingen City</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Audrey Hall</td>
                    <td>7 Earl Hall, Backlund</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Alger Wilson</td>
                    <td>126 Waterway Street, Backlund</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Derrick Berg</td>
                    <td>Explorer's Rest, Land Abandoned by God</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Amon</td>
                    <td>Time's Domain, Unknown</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Leonard Mitchell</td>
                    <td>Red Gloves Headquarters, Backlund</td>
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
