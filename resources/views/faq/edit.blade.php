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
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Form Edit FAQ</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="faqEditForm" action="{{ route('faq.update', $faq->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="question" class="form-label">Pertanyaan</label>
                                    <input type="text" class="form-control rounded-pill px-3 py-2" id="question" name="question" 
                                           value="{{ old('question', $faq->question) }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="answer" class="form-label">Jawaban</label>
                                    <textarea class="form-control rounded-lg" id="answer" name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                                </div>

                                <div class="d-flex justify-content-start gap-2">
                                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" id="confirmUpdateBtn">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                    <a href="{{ route('faq.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
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
