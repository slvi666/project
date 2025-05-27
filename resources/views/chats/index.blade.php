@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 fw-bold text-primary">
            <i class="fas fa-comments me-2"></i>Daftar Pesan
          </h1>
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

              <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <input type="text" id="search" placeholder="🔍 Cari pesan..." class="form-control shadow-sm">
                <button id="btnTambahPesan" class="btn btn-primary shadow-sm">
                  <i class="fas fa-plus-circle me-1"></i> Pesan Baru
                </button>
              </div>

              <div class="table-responsive">
                <table id="pesanTable" class="table table-bordered table-striped align-middle">
                  <thead class="text-center">
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
                        <td>{{ $message->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                          <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <button class="btn btn-success btn-sm shadow-sm btnBacaPesan" 
                              data-url="{{ route('messages.show', ['receiver_id' => $receiver->id]) }}">
                              <i class="fas fa-envelope-open-text me-1"></i> Baca
                            </button>
                            <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                </button>
                            </form>

                            </form>
                          </div>
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
      const start = (page - 1) * rowsPerPage + 1;
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
        btn.className = "page-btn";
        if (i === currentPage) btn.classList.add("active");
        btn.onclick = () => {
          currentPage = i;
          showPage(i);
          setupPagination();
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

  document.getElementById("btnTambahPesan").addEventListener("click", function () {
    Swal.fire({
      title: 'Tambah Pesan Baru?',
      text: "Anda akan diarahkan ke halaman pembuatan pesan.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Lanjut',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('messages.create') }}";
      }
    });
  });

  document.querySelectorAll(".btnBacaPesan").forEach(button => {
    button.addEventListener("click", function () {
      const url = this.getAttribute("data-url");
      Swal.fire({
        title: 'Baca Pesan?',
        text: "Anda akan melihat isi percakapan.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Lanjut',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    });
  });

  document.querySelectorAll("form").forEach(form => {
    const deleteButton = form.querySelector('button[type="submit"]');
    if (deleteButton && deleteButton.textContent.includes("Hapus")) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: "Pesan akan dihapus permanen.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    }
  });
</script>

<style>
  .card-title {
    font-size: 1.4rem;
    font-weight: 600;
  }

  .table th, .table td {
    vertical-align: middle !important;
  }

  .table thead th {
    background: linear-gradient(90deg, #007bff, #3399ff);
    color: white;
    border: none;
  }

  .btn {
    transition: all 0.2s ease-in-out;
  }

  .btn:hover {
    transform: translateY(-2px);
  }

  .btn-primary {
    background: linear-gradient(45deg, #007bff, #3399ff);
    border: none;
  }

  .btn-success {
    background: linear-gradient(45deg, #28a745, #42d392);
    border: none;
  }

  .btn-danger {
    background: linear-gradient(45deg, #dc3545, #e76e84);
    border: none;
  }

  #search {
    max-width: 300px;
    border-radius: 50px !important;
    padding-left: 1.5rem !important;
  }

  .swal2-popup {
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
  }

  #pagination button {
    background-color: #f0f0f0;
    border: none;
    color: #333;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 6px;
    margin: 0 2px;
  }

  #pagination button:hover,
  #pagination button.active {
    background-color: #007bff;
    color: white;
  }
</style>
@endsection
