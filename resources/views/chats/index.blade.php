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
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0">Daftar Pesan</h3>
              <a href="{{ route('messages.create') }}"
                <i class="fas fa-plus me-1"></i> Pesan Baru
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">#</th>
                      <th>Dengan</th>
                      <th>Pesan Terakhir</th>
                      <th>Waktu</th>
                      <th style="width: 15%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($conversations as $index => $message)
                      @php
                        $receiver = $message->sender_id == auth()->id() ? $message->receiver : $message->sender;
                      @endphp
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $receiver->name }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center">
                          <a href="{{ route('messages.show', ['receiver_id' => $receiver->id]) }}" class="btn btn-info btn-sm rounded-pill shadow-sm">
                            <i class="fas fa-eye"></i> Lihat
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center">Belum ada percakapan.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              {{-- Optional Pagination / Search can be added here --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
