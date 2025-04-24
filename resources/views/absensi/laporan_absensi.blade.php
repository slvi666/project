@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    {{-- Header --}}
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Absensi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Laporan Absensi</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    {{-- Konten --}}
    <section class="content">
      <div class="container-fluid">
        <div class="card shadow-sm border-0">
          {{-- Filter --}}
          <div class="card-header bg-info text-white">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
          </div>
          <div class="card-body">
            <form method="GET" action="{{ route('absensi.laporan') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <label><i class="fas fa-calendar-alt"></i> Tanggal</label>
                  <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>
                <div class="col-md-3">
                  <label><i class="fas fa-check-circle"></i> Status</label>
                  <select name="status" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin"  {{ request('status') == 'izin'  ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                  </select>
                </div>
                <div class="col-md-3">
                    <label><i class="fas fa-book"></i> Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" class="form-control">
                      <option value="">-- Semua --</option>
                      @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id }}" {{ request('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                          {{ optional($mp->subject)->subject_name ?? '-' }} - 
                          {{ optional(optional($mp->guru)->user)->name ?? '-' }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
                <div class="col-md-3 d-flex align-items-end">
                  <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
              </div>
            </form>

            {{-- Pencarian client-side --}}
            <input type="text" id="search" placeholder="Cari Laporan Absensi" class="form-control mb-3">

            {{-- Tabel --}}
            <div class="table-responsive">
              <table id="absensiTable" class="table table-bordered table-striped table-hover">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($absensi as $index => $item)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y H:i') }}</td>
                      <td>{{ optional(optional($item->siswa)->user)->name ?? '-' }}</td>
                      <td>
                        {{ 
                          optional(
                            optional($item->mataPelajaran)->subject
                          )->subject_name 
                          ?? '-' 
                        }}
                      </td>
                      <td>
                        @php
                          $badgeClass = [
                            'hadir' => 'success',
                            'izin'  => 'info',
                            'sakit' => 'warning',
                            'alpha' => 'danger',
                          ][$item->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($item->status) }}</span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            {{-- Pagination client-side --}}
            <div id="pagination" class="mt-3 text-center"></div>

            {{-- Jumlah data --}}
            <p class="mt-2"><strong>{{ $absensi->count() }}</strong> data ditemukan.</p>
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- Script pencarian + pagination --}}
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const table     = document.getElementById("absensiTable");
      const searchIn  = document.getElementById("search");
      const rows      = table.getElementsByTagName("tr");
      const pagination= document.getElementById("pagination");
      let currentPage = 1;
      const rowsPerPage = 5;

      function showPage(page) {
        const start = (page - 1) * rowsPerPage + 1;
        const end   = start + rowsPerPage;
        for (let i = 1; i < rows.length; i++) {
          rows[i].style.display = (i >= start && i < end) ? "" : "none";
        }
      }

      function setupPagination() {
        pagination.innerHTML = "";
        const pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
        for (let i = 1; i <= pageCount; i++) {
          const btn = document.createElement("button");
          btn.innerText = i;
          btn.className = "btn btn-sm btn-outline-primary mx-1";
          if (i === currentPage) {
            btn.classList.add("active");
          }
          btn.addEventListener("click", () => {
            currentPage = i;
            showPage(i);
          });
          pagination.appendChild(btn);
        }
      }

      // event search
      searchIn.addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        for (let i = 1; i < rows.length; i++) {
          const text = rows[i].textContent.toLowerCase();
          rows[i].style.display = text.includes(filter) ? "" : "none";
        }
        // reset paging
        currentPage = 1;
        setupPagination();
        showPage(1);
      });

      // inisialisasi
      setupPagination();
      showPage(1);
    });
  </script>
@endsection
