@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Absensi</h1>
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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Absensi</h3>
            </div>
            <form method="GET" action="{{ route('absensi.cetak', $mataPelajaran->id) }}" target="_blank" class="mb-3">
              <div class="row">
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
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                  </button>
                </div>
              </div>
            </form>
            <div class="card-body">
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

              <p><strong>Mata Pelajaran:</strong> {{ $mataPelajaran->subject->subject_name ?? '-' }}</p>
              <p><strong>Guru:</strong> {{ $mataPelajaran->guru->name ?? '-' }}</p>

              {{-- Filter --}}
              <form method="GET" action="{{ route('absensi.index', $mataPelajaran->id) }}" class="mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                      value="{{ request('tanggal') }}">
                  </div>
                  <div class="col-md-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                      <option value="">-- Semua Status --</option>
                      <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                      <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                      <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                  </div>
                  <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="{{ route('absensi.index', $mataPelajaran->id) }}" class="btn btn-secondary">Reset</a>
                  </div>
                </div>
              </form>

              {{-- Tabel --}}
              <table id="absensiTable" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Waktu</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($absensi as $tanggal => $items)
                    <tr class="table-secondary">
                      <td colspan="3"><strong>{{ $tanggal }}</strong></td>
                    </tr>
                    @foreach ($items as $item)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</td>
                        <td>{{ $item->siswa->user->name ?? '-' }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                      </tr>
                    @endforeach
                  @empty
                    <tr>
                      <td colspan="3" class="text-center">Tidak ada data absensi.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>

              <div id="pagination" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

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
    }

    function setupPagination() {
      pagination.innerHTML = "";
      let pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        let btn = document.createElement("button");
        btn.innerText = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = function () { currentPage = i; showPage(i); };
        pagination.appendChild(btn);
      }
    }

    showPage(1);
    setupPagination();
  });
</script>
@endsection
