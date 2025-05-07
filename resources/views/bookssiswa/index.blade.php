@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Buku</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Buku</li>
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
                            <h3 class="card-title m-0">Daftar Buku</h3>
                        </div>

                        <div class="card-body">



                            <div class="row row-cols-1 row-cols-md-3 g-4" id="bookList">
                                @foreach ($buku as $item)
                                <div class="col mb-4 book-item" data-category="{{ $item->category }}" data-author="{{ $item->author }}">
                                    <div class="card h-100 shadow-sm border-light">
                                        <img src="{{ asset('storage/' . $item->cover_buku) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 250px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                                            <a href="{{ route('buku.show', $item->id) }}" class="btn btn-info btn-sm rounded-pill shadow-sm">
                                                <i class="bi bi-eye"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div id="pagination" class="mt-3 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection
