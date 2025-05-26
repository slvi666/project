@extends('adminlte.layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
/* Styling agar Select2 seragam dengan form input lain */
.select2-container .select2-selection--single {
  height: 38px !important;
  border-radius: 50px !important;
  padding: 6px 12px !important;
  border: 1px solid #ced4da !important;
  font-size: 14px;
  background-color: #fff !important;
  box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
}

.select2-selection__rendered {
  line-height: 24px !important;
}

.select2-selection__arrow {
  height: 36px !important;
  top: 1px !important;
  right: 10px;
}

.select2-container--default.select2-container--focus .select2-selection--single {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Data Guru</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Daftar Guru</a></li>
            <li class="breadcrumb-item active">Tambah Data Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Form Tambah Guru</h5>
            </div>
            <div class="card-body">

              @if ($errors->any())
                <script>
                  Swal.fire({
                    title: 'Kesalahan!',
                    html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                </script>
              @endif

              <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                  <label for="user_id" class="form-label">Nama Guru</label>
                  <select name="user_id" id="user_id" class="form-control select2"
                    @if(auth()->user()->role_name === 'guru') disabled @endif required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" data-name="{{ $user->name }}"
                        {{ auth()->user()->id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                      </option>
                    @endforeach
                  </select>

                  @if(auth()->user()->role_name === 'guru')
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="nama_guru" value="{{ auth()->user()->name }}">
                  @else
                    <input type="hidden" name="nama_guru" id="nama_guru">
                  @endif
                </div>

                <div class="mb-3">
                  <label for="nip" class="form-label">NIP</label>
                  <input type="text" name="nip" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea name="alamat" class="form-control rounded-4 px-3 py-2" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control rounded-pill px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="telepon" class="form-label">Telepon</label>
                  <input type="text" name="telepon" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-3">
                  <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                  <input type="date" name="tanggal_bergabung" class="form-control rounded-pill px-3 py-2" required>
                </div>

                <div class="mb-4">
                  <label for="foto" class="form-label">Foto (opsional)</label>
                  <input type="file" name="foto" class="form-control rounded-pill px-3 py-2">
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="{{ route('guru.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                  </a>
                  <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Simpan
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    $('#user_id').select2({
      placeholder: '-- Pilih User --',
      allowClear: true
    });

    $('#user_id').on('change', function () {
      let selectedOption = $(this).find('option:selected');
      let userName = selectedOption.data('name');
      $('#nama_guru').val(userName);
    });
  });
</script>
@endsection
