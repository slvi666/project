@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pesan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Pesan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h3 class="card-title m-0">Daftar Pesan</h3>
              <a href="{{ route('messages.create') }}" class="btn btn-primary text-light fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-1"></i> Pesan Baru
              </a>
            </div>

            <div class="card-body">
              @if(session('success'))
              <script>
                Swal.fire({
                  title: 'Berhasil!',
                  text: "{{ session('success') }}",
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then(() => {
                  window.location.reload();
                });
              </script>
              @endif

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="search" placeholder="🔍 Cari ..." class="form-control w-50 shadow-sm rounded-pill px-3">
              </div>

              <div class="table-responsive">
                <table id="pesanTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Dengan</th>
                      <th>Pesan Terakhir</th>
                      <th>Waktu</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($conversations as $index => $message)
                      @php
                        $receiver = $message->sender_id == auth()->id() ? $message->receiver : $message->sender;
                      @endphp
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $receiver->name }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                          <a href="{{ route('messages.show', ['receiver_id' => $receiver->id]) }}" class="btn btn-success btn-sm rounded-pill shadow-sm text-white me-2">
                            <i class="fas fa-envelope-open-text"></i> Baca Pesan
                          </a>
                       <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-inline">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm">Hapus</button>
</form>

                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada percakapan.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div id="pagination" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("pesanTable");
    const searchInput = document.getElementById("search");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("pagination");
    let currentPage = 1;
    const rowsPerPage = 5;

    function showPage(page) {
      const start = (page - 1) * rowsPerPage + 1; // +1 to skip header
      const end = start + rowsPerPage;
      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      const pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = () => {
          currentPage = i;
          showPage(i);
        };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      for (let i = 1; i < rows.length; i++) {
        const text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "" : "none";
      }
    });

    showPage(currentPage);
    setupPagination();
  });
</script>
@endsection
