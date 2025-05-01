@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-clipboard-list me-2"></i> Data Absensi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Absensi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card shadow-lg rounded-4">
            <div class="card-header bg-gradient-primary text-white rounded-top">
              <h3 class="card-title"><i class="fas fa-table me-2"></i> Rekapitulasi Absensi</h3>
            </div>

            <div class="card-body">
              {{-- Cetak PDF --}}
              @if(in_array(auth()->user()->role_name, ['Admin', 'guru']))
              <form method="GET" action="{{ route('absensi.cetak', $mataPelajaran->id) }}" target="_blank" class="mb-4 p-3 bg-light rounded shadow-sm">
                <div class="row g-2">
                  <div class="col-md-3">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" placeholder="Tanggal">
                  </div>
                  <div class="col-md-3">
                    <select name="status" class="form-control">
                      <option value="">-- Status --</option>
                      <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                      <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                      <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                      <option value="alfa" {{ request('status') == 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="nama_siswa" value="{{ request('nama_siswa') }}" class="form-control" placeholder="Nama Siswa">
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-danger w-100">
                      <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                    </button>
                  </div>
                </div>
              </form>
              @endif

              {{-- Alert SweetAlert --}}
              @if(session('success'))
              <script>
                Swal.fire({
                  title: 'Berhasil!',
                  text: "{{ session('success') }}",
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              </script>
              @endif

              {{-- Info Mata Pelajaran & Guru --}}
              <div class="row mb-4 g-3">
                <div class="col-md-6">
                  <div class="card border-0 shadow-lg rounded-4 bg-primary text-white h-100">
                    <div class="card-body d-flex align-items-center">
                      <div class="me-3">
                        <div class="bg-white text-primary rounded-circle p-3 shadow-sm">
                          <i class="fas fa-book-open fa-2x"></i>
                        </div>
                      </div>
                      <div>
                        <h6 class="mb-1 fw-semibold text-light">Mata Pelajaran</h6>
                        <h4 class="fw-bold mb-0">{{ $mataPelajaran->subject->subject_name ?? '-' }}</h4>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card border-0 shadow-lg rounded-4 bg-success text-white h-100">
                    <div class="card-body d-flex align-items-center">
                      <div class="me-3">
                        <div class="bg-white text-success rounded-circle p-3 shadow-sm">
                          <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                      </div>
                      <div>
                        <h6 class="mb-1 fw-semibold text-light">Guru Pengajar</h6>
                        <h4 class="fw-bold mb-0">{{ $mataPelajaran->guru->name ?? '-' }}</h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Filter Data --}}
              <form method="GET" action="{{ route('absensi.index', $mataPelajaran->id) }}" class="mb-4 p-3 border rounded shadow-sm bg-white">
                <div class="row g-2 align-items-end">
                  <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
                  </div>
                  <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                      <option value="">-- Semua Status --</option>
                      <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                      <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                      <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                      <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                  </div>
                  <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-primary flex-grow-1 me-2">
                      <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('absensi.index', $mataPelajaran->id) }}" class="btn btn-secondary flex-grow-1">
                      <i class="fas fa-undo"></i> Reset
                    </a>
                  </div>
                </div>
              </form>

              {{-- Tabel Data --}}
              <div class="table-responsive">
                <table id="absensiTable" class="table table-bordered table-hover align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>Waktu</th>
                      <th>Nama Siswa</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($absensi as $tanggal => $items)
                      <tr class="table-secondary text-center">
                        <td colspan="3"><strong>{{ $tanggal }}</strong></td>
                      </tr>
                      @foreach ($items as $item)
                        <tr class="text-center">
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</td>
                          <td>{{ $item->siswa->user->name ?? '-' }}</td>
                          <td>
                            @php
                              $statusColor = [
                                'hadir' => 'success',
                                'izin' => 'primary',
                                'sakit' => 'warning',
                                'alpha' => 'danger'
                              ];
                              $color = $statusColor[strtolower($item->status)] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }} rounded-pill px-3 py-2">
                              {{ ucfirst($item->status) }}
                            </span>
                          </td>
                        </tr>
                      @endforeach
                    @empty
                      <tr>
                        <td colspan="3" class="text-center">Tidak ada data absensi.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              {{-- Pagination --}}
              <div id="pagination" class="mt-4 text-center"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

{{-- Manual Pagination --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    let table = document.getElementById("absensiTable");
    let rows = table.getElementsByTagName("tr");
    let currentPage = 1;
    let rowsPerPage = 10;
    let pagination = document.getElementById("pagination");

    function showPage(page) {
      let start = (page - 1) * rowsPerPage + 1;
      let end = start + rowsPerPage;
      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "table-row" : "none";
      }
      updateButtons();
    }

    function updateButtons() {
      document.getElementById("prevBtn").disabled = currentPage === 1;
      document.getElementById("nextBtn").disabled = currentPage === Math.ceil((rows.length - 1) / rowsPerPage);
    }

    function setupPagination() {
      pagination.innerHTML = `
        <button id="prevBtn" class="btn btn-outline-primary btn-sm mx-1">Previous</button>
        <span class="mx-2">Page <span id="currentPage">${currentPage}</span></span>
        <button id="nextBtn" class="btn btn-outline-primary btn-sm mx-1">Next</button>
      `;

      document.getElementById("prevBtn").addEventListener("click", function () {
        if (currentPage > 1) {
          currentPage--;
          showPage(currentPage);
          document.getElementById('currentPage').innerText = currentPage;
        }
      });

      document.getElementById("nextBtn").addEventListener("click", function () {
        if (currentPage < Math.ceil((rows.length - 1) / rowsPerPage)) {
          currentPage++;
          showPage(currentPage);
          document.getElementById('currentPage').innerText = currentPage;
        }
      });

      showPage(currentPage);
    }
    setupPagination();
  });
</script>
@endsection
