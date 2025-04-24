@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit FAQ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Edit FAQ</li>
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
                            <h3 class="card-title">Form Edit FAQ</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        Swal.fire({
                                            title: 'Kesalahan!',
                                            html: `<ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>`,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    });
                                </script>
                            @endif

                            <form id="faqEditForm" action="{{ route('faq.update', $faq->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="question">Pertanyaan</label>
                                    <input type="text" class="form-control" id="question" name="question" 
                                           value="{{ old('question', $faq->question) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="answer">Jawaban</label>
                                    <textarea class="form-control" id="answer" name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                                </div>

                                <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Update</button>
                                <a href="{{ route('faq.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Confirmation -->
<script>
    document.getElementById('confirmUpdateBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin mengubah FAQ ini?',
            text: "Perubahan akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('faqEditForm').submit();
            }
        });
    });
</script>
@endsection
