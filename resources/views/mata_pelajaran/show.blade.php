@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary">Detail Mata Pelajaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('mata-pelajaran.index') }}">Mata Pelajaran</a></li>
                        <li class="breadcrumb-item active">Detail Mata Pelajaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-lg rounded-4 w-100">
                        <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top">
                            <h3 class="card-title m-0">Informasi Mata Pelajaran</h3>
                        </div>

                        <div class="card-body p-5">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h5 class="fw-bold text-dark">
                                            <i class="fas fa-chalkboard-teacher me-2 text-primary"></i> Guru:
                                        </h5>
                                        <p class="fs-5 text-dark">{{ $data->guru->name }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="fw-bold text-dark">
                                            <i class="fas fa-book me-2 text-success"></i> Mata Pelajaran:
                                        </h5>
                                        <p class="fs-5 text-dark">{{ $data->subject->subject_name }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="fw-bold text-dark">
                                            <i class="fas fa-calendar-alt me-2 text-info"></i> Waktu:
                                        </h5>
                                        <p class="fs-5 text-dark">{{ $data->waktu_mulai }} - {{ $data->waktu_berakhir }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="fw-bold text-dark">
                                            <i class="fas fa-calendar-check me-2 text-warning"></i> Hari:
                                        </h5>
                                        <p class="fs-5 text-dark">{{ $data->hari }}</p>
                                    </div>
                                </div>

                               <!-- Right Column -->
                                {{-- <div class="col-md-6">
                                    <div class="mb-4">
                                        <h5 class="fw-bold text-dark">
                                            <i class="fas fa-users me-2 text-primary"></i> Siswa yang Terdaftar:
                                        </h5>
                                        <ul class="fs-5 text-dark">
                                            @foreach($data->siswa_ids as $siswaId)
                                                <li>{{ $siswaId }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center rounded-bottom">
                            <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow-lg rounded-pill">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function hapusData(id) {
        if (confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
