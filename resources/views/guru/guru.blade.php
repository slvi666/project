@extends('adminlte.layouts.app')

@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper bg-light">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark font-weight-bold">Selamat datang di Halaman {{ auth()->user()->role_name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Halaman Super Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      {{-- 3 Card Sejajar --}}
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-body text-muted">Card 1</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-body text-muted">Card 2</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-body text-muted">Card 3</div>
          </div>
        </div>
      </div>

      {{-- 2 Card Di Bawahnya --}}
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="card bg-white border shadow-sm">
            <div class="card-body text-muted">Card 4</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card bg-white border shadow-sm">
            <div class="card-body text-muted">Card 5</div>
          </div>
        </div>
      </div>

      {{-- 3 Table Sejajar --}}
      <div class="row">
        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-header bg-light text-dark font-weight-bold">Tabel 1</div>
            <div class="card-body p-0">
              <table class="table table-sm table-hover table-borderless mb-0">
                <thead class="thead-light">
                  <tr>
                    <th>Kolom</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Contoh</td>
                    <td>Data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-header bg-light text-dark font-weight-bold">Tabel 2</div>
            <div class="card-body p-0">
              <table class="table table-sm table-hover table-borderless mb-0">
                <thead class="thead-light">
                  <tr>
                    <th>Kolom</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Contoh</td>
                    <td>Data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card bg-white border shadow-sm">
            <div class="card-header bg-light text-dark font-weight-bold">Tabel 3</div>
            <div class="card-body p-0">
              <table class="table table-sm table-hover table-borderless mb-0">
                <thead class="thead-light">
                  <tr>
                    <th>Kolom</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Contoh</td>
                    <td>Data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
