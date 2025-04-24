@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Seleksi Berkas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Seleksi Berkas</li>
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
                <h3 class="card-title">Daftar Seleksi Berkas</h3>
                <div class="card-tools">
                  <a href="{{ route('seleksi-berkas.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
              </div>
              <div class="card-body">
                <input type="text" id="searchBerkas" class="form-control mb-3" placeholder="Cari...">
                <table id="berkasTable" class="table table-bordered table-striped">
                  <thead class="bg-success text-white">
                    <tr>
                      <th>No</th>
                      <th>Nama User</th>
                      <th>Formulir Pendaftaran ID</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->formulir_pendaftaran_id }}</td>
                        <<td>
                            <a href="{{ route('seleksi-berkas.show', $item->id) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('seleksi-berkas.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                        </td>
                        
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-3">
                  {{ $data->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      setupTable("berkasTable", "searchBerkas");
    });

    function setupTable(tableId, searchId) {
      let table = document.getElementById(tableId);
      if (!table) return;

      let rows = Array.from(table.getElementsByTagName("tbody")[0].rows);
      let searchInput = document.getElementById(searchId);

      searchInput.addEventListener("input", function() {
        let filter = searchInput.value.toLowerCase();
        rows.forEach(row => {
          let text = row.textContent.toLowerCase();
          row.style.display = text.includes(filter) ? "" : "none";
        });
      });
    }

    function confirmDelete(form) {
      Swal.fire({
        title: 'Anda yakin?',
        text: "Data ini akan dihapus!",
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

    function confirmEdit(url) {
      Swal.fire({
        title: 'Anda yakin ingin mengedit?',
        text: "Anda akan diarahkan ke halaman edit.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = url;
        }
      });
    }
  </script>
@endsection
