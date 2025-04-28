@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary">Form Absensi Siswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Absensi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-lg rounded-4">
        <div class="card-header bg-gradient-success text-white rounded-top">
          <h3 class="card-title">Input Absensi</h3>
        </div>

        <div class="card-body">
          <!-- Info Mata Pelajaran dan Guru -->
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="border p-3 rounded bg-light">
                <p><strong>Mata Pelajaran:</strong> {{ $mataPelajaran->subject->subject_name ?? '-' }}</p>
                <p><strong>Guru Pengajar:</strong> {{ $mataPelajaran->guru->name ?? '-' }}</p>
              </div>
            </div>
          </div>

          <!-- Form Absensi -->
          <form id="absensiForm" action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id }}">

            <!-- Input Tanggal -->
            <div class="row mb-4">
              <div class="col-md-6">
                <label for="tanggal" class="form-label fw-semibold">
                  <i class="bi bi-calendar-event-fill me-1"></i> Tanggal & Waktu Absensi
                </label>
                <input type="datetime-local" name="tanggal" class="form-control" required>
              </div>
            </div>

            <!-- Tabel Absensi -->
            <div class="table-responsive">
              <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                  <tr>
                    <th>Nama Siswa</th>
                    <th>Status Kehadiran</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($siswa as $s)
                  <tr>
                    <td>
                      <i class="bi bi-person-circle text-secondary me-1"></i> {{ $s->user->name }}
                      <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">
                    </td>
                    <td class="text-center">
                       <!-- Stylish Radio Buttons for Status -->
                      <div class="d-flex justify-content-center align-items-center">
                        <div class="btn-group" role="group">
                          <input type="radio" class="btn-check" name="status[{{ $loop->index }}]" id="hadir{{ $loop->index }}" value="Hadir" checked>
                          <label class="btn btn-outline-success rounded-pill px-4 py-2" for="hadir{{ $loop->index }}">
                            <i class="bi bi-check-circle-fill me-1"></i> Hadir
                          </label>

                          <input type="radio" class="btn-check" name="status[{{ $loop->index }}]" id="izin{{ $loop->index }}" value="Izin">
                          <label class="btn btn-outline-primary rounded-pill px-4 py-2" for="izin{{ $loop->index }}">
                            <i class="bi bi-file-earmark-text-fill me-1"></i> Izin
                          </label>

                          <input type="radio" class="btn-check" name="status[{{ $loop->index }}]" id="sakit{{ $loop->index }}" value="Sakit">
                          <label class="btn btn-outline-warning rounded-pill px-4 py-2" for="sakit{{ $loop->index }}">
                            <i class="bi bi-emoji-frown-fill me-1"></i> Sakit
                          </label>

                          <input type="radio" class="btn-check" name="status[{{ $loop->index }}]" id="alpha{{ $loop->index }}" value="Alpha">
                          <label class="btn btn-outline-danger rounded-pill px-4 py-2" for="alpha{{ $loop->index }}">
                            <i class="bi bi-x-circle-fill me-1"></i> Alpha
                          </label>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Tombol Submit -->
            <div class="row justify-content-center mt-4">
              <div class="col-md-4 text-center">
                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill">
                  <i class="bi bi-save-fill me-1"></i> Simpan Absensi
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('absensiForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent form submission

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
        // Submit the form if confirmed
        this.submit();
      }
    });
  });
</script>
@endsection
