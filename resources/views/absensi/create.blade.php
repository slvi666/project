@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">
                <i class="bi bi-clipboard-check-fill text-primary me-2"></i> Form Absensi Siswa
            </h2>
            <p class="text-muted">Silakan isi absensi untuk setiap siswa pada tanggal yang ditentukan.</p>
        </div>
    </div>

    <!-- Info Mata Pelajaran dan Guru -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-journal-bookmark-fill text-success me-2"></i> Informasi Pelajaran</h5>
                    <p><strong>Mata Pelajaran:</strong> {{ $mataPelajaran->subject->subject_name ?? '-' }}</p>
                    <p><strong>Guru Pengajar:</strong> {{ $mataPelajaran->guru->name ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Absensi -->
    <form id="absensiForm" action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id }}">

        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <label for="tanggal" class="form-label fw-semibold">
                    <i class="bi bi-calendar-event-fill me-1"></i> Tanggal & Waktu Absensi
                </label>
                <input type="datetime-local" name="tanggal" class="form-control" required>
            </div>
        </div>
        

        <!-- Tabel Absensi -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="table-responsive shadow-sm">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th><i class="bi bi-person-fill"></i> Nama Siswa</th>
                                <th><i class="bi bi-activity"></i> Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>
                                        <i class="bi bi-person-circle text-secondary me-1"></i>
                                        {{ $s->user->name }}
                                        <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">
                                    </td>
                                    <td>
                                        <select name="status[]" class="form-select">
                                            <option value="Hadir">✅ Hadir</option>
                                            <option value="Izin">📄 Izin</option>
                                            <option value="Sakit">🤒 Sakit</option>
                                            <option value="Alpha">❌ Alpha</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 text-center">
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-save-fill me-1"></i> Simpan Absensi
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('absensiForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Absensi?',
            text: "Pastikan data sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endsection
