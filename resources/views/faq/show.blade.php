@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail FAQ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
            <li class="breadcrumb-item active">Detail FAQ</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded-3 w-100">
            <div class="card-header bg-primary text-white text-center py-4" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
              <h3 class="card-title m-0">Detail Pertanyaan</h3>
            </div>
            <div class="card-body">
              <!-- Pertanyaan -->
              <div class="mb-4">
                <h5 class="fw-bold mb-3" style="color: #333;">Pertanyaan:</h5>
                <p class="m-0 fs-5" style="line-height: 1.6; font-weight: 500;">{{ $faq->question }}</p>
              </div>

              <!-- Jawaban -->
              <div class="mb-3">
                <h5 class="text-muted mb-3">Jawaban:</h5>
                <p class="fs-5" style="line-height: 1.8; font-weight: 400;">{{ $faq->answer }}</p>
              </div>

              <!-- Waktu Dibuat -->
              <div class="text-muted mt-4">
                <small>Dibuat pada: {{ $faq->created_at->translatedFormat('d F Y, H:i') }}</small>
              </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
              <!-- Tombol kembali yang lebih kecil dan lebih smooth -->
              <a href="{{ route('faq.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow-lg rounded-pill" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
