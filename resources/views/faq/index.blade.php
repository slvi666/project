@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar FAQ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">FAQ</li>
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
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Pertanyaan yang Sering Diajukan</h3>
            </div>

            <div class="card-body">
              @if (session('success'))
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
                <input type="text" id="searchInput" placeholder="🔍 Cari FAQ..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('faq.create') }}')" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                  <i class="fas fa-plus-circle me-1"></i> Tambah FAQ
                </a>
              </div>

              <div class="table-responsive">
                <table id="faqTable" class="table table-bordered table-striped">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>No</th>
                      <th>Pertanyaan</th>
                      <th>Jawaban</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($faqs as $faq)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faq->question }}</td>
                        <td>{{ $faq->answer }}</td>
                        <td class="text-center">
                           <a href="javascript:void(0)" onclick="confirmView('{{ route('faq.show', $faq->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-eye"></i>
                          </a>    
                          <button onclick="confirmEdit('{{ route('faq.edit', $faq->id) }}')" class="btn btn-warning btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-edit"></i>
                          </button>
                          <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center">Belum ada FAQ</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div id="paginationContainer" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah FAQ Baru?',
      text: "Anda akan diarahkan ke halaman tambah FAQ.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmEdit(url) {
    Swal.fire({
      title: 'Anda yakin ingin mengedit?',
      text: "Anda akan diarahkan ke halaman edit FAQ.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmDelete(form) {
    Swal.fire({
      title: 'Hapus FAQ ini?',
      text: "Data yang dihapus tidak dapat dikembalikan.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  }

  function confirmView(url) {
  Swal.fire({
    title: 'Lihat Detail FAQ?',
    text: "Anda akan diarahkan ke halaman detail FAQ.",
    icon: 'info',
    confirmButtonText: 'Lanjutkan'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}

  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("faqTable");
    const searchInput = document.getElementById("searchInput");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("paginationContainer");
    let currentPage = 1;
    const rowsPerPage = 5;

    function showPage(page) {
      const start = (page - 1) * rowsPerPage + 1;
      const end = start + rowsPerPage;

      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "table-row" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      const pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement("button");
        btn.innerText = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = function () {
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
        rows[i].style.display = text.includes(filter) ? "table-row" : "none";
      }
    });

    showPage(currentPage);
    setupPagination();
  });
</script>
@endsection
