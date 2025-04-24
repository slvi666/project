@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit Seleksi Berkas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('seleksi-berkas.update', $seleksiBerkas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @foreach ([
                            'poto_ktp_orang_tua' => 'Foto KTP Orang Tua',
                            'kartu_keluarga' => 'Kartu Keluarga',
                            'akte_kelahiran' => 'Akte Kelahiran',
                            'surat_kelulusan' => 'Surat Kelulusan',
                            'raport' => 'Raport',
                            'kis_kip' => 'KIS/KIP',
                            'ijazah' => 'Ijazah'] as $name => $label)
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ $label }}:</label>
                            <input type="file" class="form-control" name="{{ $name }}">
                            @if ($seleksiBerkas->$name)
                                <a href="{{ asset('storage/' . $seleksiBerkas->$name) }}" target="_blank" class="d-block mt-2 text-primary">Lihat File</a>
                            @endif
                        </div>
                        @endforeach

                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
