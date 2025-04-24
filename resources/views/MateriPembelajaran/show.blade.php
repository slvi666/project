@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                    <i class="bi bi-journal-text me-2 fs-4"></i>
                    <h4 class="mb-0">Detail Materi Pembelajaran</h4>
                </div>

                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="bi bi-person-fill me-2 text-primary"></i>
                            <strong>Guru:</strong> {{ $materi->guru->name }}
                        </div>
                        <div class="col-md-6">
                            <i class="bi bi-book-half me-2 text-success"></i>
                            <strong>Mata Pelajaran:</strong> {{ $materi->subject->subject_name }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="bi bi-people-fill me-2 text-warning"></i>
                            <strong>Kelas:</strong> {{ $materi->subject->class_name }}
                        </div>
                        <div class="col-md-6">
                            <i class="bi bi-calendar-event me-2 text-info"></i>
                            <strong>Tanggal Update:</strong> {{ $materi->created_at->format('d M Y') }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <i class="bi bi-card-text me-2 text-danger"></i>
                        <strong>Deskripsi:</strong>
                        <p class="mt-1 text-muted">{{ $materi->deskripsi }}</p>
                    </div>

                    <div class="mb-4">
                        <i class="bi bi-file-earmark-pdf-fill me-2 text-danger fs-5"></i>
                        <strong>File Materi:</strong><br>
                        <a href="{{ asset('storage/' . $materi->file) }}" target="_blank" class="btn btn-outline-danger mt-2">
                            <i class="bi bi-eye-fill me-1"></i> Lihat Materi
                        </a>
                    </div>

                    {{-- Opsional: Preview Gambar jika kamu simpan thumbnail --}}
                    {{-- <div class="mb-4 text-center">
                        <img src="{{ asset('storage/thumbnails/' . $materi->thumbnail) }}" alt="Thumbnail PDF" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    </div> --}}

                    {{-- Badge Status Materi --}}
                    {{-- Misalnya kamu punya kolom status --}}
                    @if(isset($materi->status))
                    <div class="mb-4">
                        <i class="bi bi-info-circle-fill me-2 text-secondary"></i>
                        <strong>Status:</strong>
                        @if($materi->status === 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('materi.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Daftar Materi
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Bootstrap Icons CDN --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
@endsection
