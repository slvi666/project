@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center text-primary">{{ $buku->judul }}</h1>

    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="book-container">
            <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="book-cover" alt="Cover Buku">
            <div class="book-info">
                <h5 class="card-title text-dark font-weight-bold">{{ $buku->judul }}</h5>
                <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                <p><strong>Kategori:</strong> <span class="badge badge-info">{{ ucfirst($buku->kategori) }}</span></p>
                <p><strong>Deskripsi:</strong> {{ $buku->deskripsi }}</p>
                <p><strong>Views:</strong> <span class="text-success font-weight-bold">{{ $buku->views }}</span></p>
            </div>
        </div>

        <!-- PDF Viewer Container -->
        <div class="pdf-container">
            <canvas id="pdf-viewer" class="pdf-viewer"></canvas>
        </div>

        <!-- Navigasi PDF -->
        <div class="pdf-navigation">
            <button id="prev-page" class="btn btn-outline-primary">Previous</button>
            <span id="page-info">Page: <span id="current-page">1</span> / <span id="total-pages"></span></span>
            <button id="next-page" class="btn btn-outline-primary">Next</button>
        </div>
        
        <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-4 back-button">Kembali</a>
    </div>
</div>

<style>
    .book-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        align-items: center;
    }
    .book-cover {
        max-width: 200px;
        height: auto;
        border-radius: 10px;
    }
    .pdf-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        padding: 10px;
        display: flex;
        justify-content: center;
        background: #f9f9f9;
    }
    .pdf-viewer {
        border-radius: 10px;
    }
    .pdf-navigation {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
    }
    .back-button {
        display: block;
        width: 200px;
        margin: 20px auto;
        text-align: center;
    }
</style>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var url = "{{ Storage::url($buku->file_buku) }}";
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js";

        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            canvas = document.getElementById("pdf-viewer"),
            ctx = canvas.getContext("2d");

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
            console.error("Error loading PDF:", error);
        });
    });

    // Mencegah klik kanan
    document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
    });
</script>
@endsection