@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4 text-center">Detail Seleksi Berkas</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Informasi Pendaftar</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nama User:</strong> {{ $seleksiBerkas->user->name }}</p>
                    <p><strong>Formulir Pendaftaran ID:</strong> {{ $seleksiBerkas->formulir_pendaftaran_id }}</p>
                </div>
            </div>
            <div class="row mt-4">
                @php
                    $documents = [
                        'Foto KTP Orang Tua' => $seleksiBerkas->poto_ktp_orang_tua,
                        'Kartu Keluarga' => $seleksiBerkas->kartu_keluarga,
                        'Akte Kelahiran' => $seleksiBerkas->akte_kelahiran,
                        'Surat Kelulusan' => $seleksiBerkas->surat_kelulusan,
                        'Raport' => $seleksiBerkas->raport,
                        'KIS/KIP' => $seleksiBerkas->kis_kip,
                        'Ijazah' => $seleksiBerkas->ijazah,
                    ];
                @endphp
                
                @foreach ($documents as $label => $file)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">{{ $label }}</h6>
                            </div>
                            <div class="card-body text-center">
                                @if ($file)
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-success btn-sm">Lihat File</a>
                                @else
                                    <p class="text-danger">Tidak ada file</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('seleksi-berkas.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection