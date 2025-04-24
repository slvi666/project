@extends('layouts.app')

@section('content')
    <h2>Tambah Seleksi Berkas</h2>
    <form action="{{ route('seleksi-berkas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>User:</label>
        <input type="text" value="{{ $user->name }}" disabled>
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <label>Formulir Pendaftaran ID:</label>
        <input type="text" value="{{ $formulir->id }}" disabled>
        <input type="hidden" name="formulir_pendaftaran_id" value="{{ $formulir->id }}">

        <label>Foto KTP Orang Tua:</label>
        <input type="file" name="poto_ktp_orang_tua"><br>

        <label>Kartu Keluarga:</label>
        <input type="file" name="kartu_keluarga"><br>

        <label>Akte Kelahiran:</label>
        <input type="file" name="akte_kelahiran"><br>

        <label>Surat Kelulusan:</label>
        <input type="file" name="surat_kelulusan"><br>

        <label>Raport:</label>
        <input type="file" name="raport"><br>

        <label>KIS/KIP:</label>
        <input type="file" name="kis_kip"><br>

        <label>Ijazah:</label>
        <input type="file" name="ijazah"><br>

        <button type="submit">Simpan</button>
    </form>
@endsection
