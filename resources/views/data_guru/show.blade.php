<!-- resources/views/data_guru/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Data Guru</h1>

    <table class="table">
        <tr>
            <th>Nama</th>
            <td>{{ $guru->user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $guru->user->email }}</td>
        </tr>
        <tr>
            <th>NIP</th>
            <td>{{ $guru->nip }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $guru->no_telpon }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $guru->alamat }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $guru->tanggal_lahir }}</td>
        </tr>
    </table>

    <a href="{{ route('data_guru.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection