@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary">Detail Buku</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
            <li class="breadcrumb-item active">Detail Buku</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded-4 w-100 border-0">
            <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top">
              <h3 class="card-title m-0">Informasi Buku</h3>
            </div>

            <div class="card-body p-4">
              <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-4 text-center">
                  <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="img-fluid rounded mb-4" alt="Cover Buku" style="max-height: 300px;">
                 <!-- Badge kategori dipindahkan ke sini -->
                 <div class="mt-2">
                    <span class="badge bg-warning fs-6 px-3 py-2 d-inline-block">{{ ucfirst($buku->kategori) }}</span>
                  </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-8">
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-book me-2 text-primary"></i> Judul:
                    </h5>
                    <p class="fs-5 text-dark"><strong>{{ $buku->judul }}</strong></p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-user-edit me-2 text-success"></i> Penulis:
                    </h5>
                    <p class="fs-5 text-dark">{{ $buku->penulis }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-eye me-2 text-warning"></i> Views:
                    </h5>
                    <p class="fs-5 text-success fw-bold">{{ $buku->views }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-align-left me-2 text-danger"></i> Deskripsi:
                    </h5>
                    <p class="fs-5 text-muted">{{ $buku->deskripsi }}</p>
                  </div>
                </div>
              </div>

              <hr class="my-5">

              <!-- PDF Viewer -->
              <div class="text-center">
                <h5 class="fw-bold mb-3"><i class="fas fa-file-pdf text-danger me-2"></i>Halaman Buku</h5>
                <div class="pdf-container mb-3">
                  <canvas id="pdf-viewer" class="pdf-viewer rounded shadow"></canvas>
                </div>

                <div class="pdf-navigation mb-4 d-flex justify-content-center gap-3">
                  <button id="prev-page" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-chevron-left"></i> 
                  </button>
                  <span class="align-self-center">: <span id="current-page">1</span> / <span id="total-pages">...</span></span>
                  <button id="next-page" class="btn btn-outline-primary btn-sm">
                     <i class="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center rounded-bottom">
              <a href="{{ route('buku.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow rounded-pill">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<style>
  .pdf-container {
    border: 1px solid #ddd;
    padding: 20px;
    background-color: #fafafa;
    display: flex;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .pdf-viewer {
    width: 100%;
    max-width: 700px;
    border-radius: 10px;
  }

  .pdf-navigation button {
    transition: all 0.3s ease;
  }

  .pdf-navigation button:hover {
    background-color: #007bff;
    color: #fff;
  }

  .card {
    border-radius: 16px;
  }

  .card-header {
    border-radius: 16px 16px 0 0;
  }

  .card-body {
    padding: 3rem;
  }

  .card-footer {
    background-color: #f8f9fa;
    border-radius: 0 0 16px 16px;
  }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var url = "{{ Storage::url($buku->file_buku) }}";
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

    var pdfDoc = null,
        pageNum = 1,
        canvas = document.getElementById("pdf-viewer"),
        ctx = canvas.getContext("2d"),
        pageRendering = false;

    function renderPage(num) {
      pageRendering = true;
      pdfDoc.getPage(num).then(function (page) {
        var scale = 1.5;
        var viewport = page.getViewport({ scale: scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        var renderTask = page.render(renderContext);

        renderTask.promise.then(function () {
          pageRendering = false;
          document.getElementById("current-page").textContent = num;
        });
      });
    }

    function queueRenderPage(num) {
      if (pageRendering) {
        setTimeout(() => queueRenderPage(num), 100);
      } else {
        renderPage(num);
      }
    }

    document.getElementById("prev-page").addEventListener("click", function () {
      if (pageNum <= 1) return;
      pageNum--;
      queueRenderPage(pageNum);
    });

    document.getElementById("next-page").addEventListener("click", function () {
      if (pageNum >= pdfDoc.numPages) return;
      pageNum++;
      queueRenderPage(pageNum);
    });

    pdfjsLib.getDocument(url).promise.then(function (pdf) {
      pdfDoc = pdf;
      document.getElementById("total-pages").textContent = pdf.numPages;
      renderPage(pageNum);
    }).catch(function (error) {
      console.error("PDF Load Error:", error);
    });
  });

  document.addEventListener("contextmenu", function (e) {
    e.preventDefault(); // Disable right click
  });
</script>
@endsection
