@extends('adminlte.layouts.app')

@section('content')
<style>
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #2f3542;
    }

    .form-container {
        max-width: 700px;
        margin: 50px auto;
        background: linear-gradient(145deg, #ffffff, #e6f0ff);
        padding: 40px 50px;
        border-radius: 25px;
        box-shadow:
            8px 8px 15px rgba(0, 0, 0, 0.1),
            -8px -8px 15px rgba(255, 255, 255, 0.8);
        transition: box-shadow 0.3s ease;
    }

    .form-container:hover {
        box-shadow:
            12px 12px 25px rgba(0, 0, 0, 0.15),
            -12px -12px 25px rgba(255, 255, 255, 0.9);
    }

    .form-container h1 {
        font-size: 2.2rem;
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
        color: #1e3a8a;
        letter-spacing: 1px;
        text-shadow: 1px 1px 2px #a3bffa;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: 700;
        color: #1e3a8a;
        letter-spacing: 0.03em;
    }

    select,
    textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #d0d7ff;
        border-radius: 15px;
        font-size: 1.1rem;
        background: #f9fbff;
        color: #2f3542;
        box-shadow: inset 2px 2px 5px rgba(255, 255, 255, 0.7);
        transition:
            border-color 0.3s ease,
            background-color 0.3s ease,
            box-shadow 0.3s ease;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    select:focus,
    textarea:focus {
        border-color: #4cd137;
        outline: none;
        background-color: #ffffff;
        box-shadow: 0 0 8px 2px rgba(76, 209, 55, 0.3);
    }

    /* Select2 overrides */
    .select2-container--default .select2-selection--single {
        border: none !important;
        padding: 10px 15px !important;
        border-radius: 15px !important;
        background: #f9fbff !important;
        box-shadow: inset 2px 2px 5px rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
        color: #2f3542;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single.select2-container--focus {
        border-color: #4cd137 !important;
        box-shadow: 0 0 8px 2px rgba(76, 209, 55, 0.3) !important;
        background-color: #ffffff !important;
        outline: none;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #2f3542;
        padding-left: 0;
        padding-right: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #4cd137 transparent transparent transparent !important;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Button */
    .btn-send {
        display: block;
        width: 100%;
        background: linear-gradient(90deg, #4cd137, #44bd32);
        color: white;
        padding: 14px 0;
        border: none;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1.2rem;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: background 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 12px rgba(76, 209, 55, 0.6);
    }

    .btn-send:hover,
    .btn-send:focus {
        background: linear-gradient(90deg, #44bd32, #3a9c27);
        box-shadow: 0 10px 20px rgba(58, 156, 39, 0.7);
        outline: none;
    }

    .btn-send i {
        margin-right: 8px;
        font-size: 1.2rem;
        vertical-align: middle;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 30px 25px;
            margin: 30px 20px;
        }

        .btn-send {
            font-size: 1rem;
        }
    }
</style>

<div class="form-container">
    <h1><i class="fas fa-paper-plane me-2"></i> Kirim Pesan</h1>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf

        <!-- Penerima -->
        <div class="form-group">
            <label for="receiver_id">Pilih Penerima</label>
            <select name="receiver_id" id="receiver_id" class="select2" required>
                <option value="">-- Pilih Penerima --</option>
                @foreach ($users as $user)
                    @if ($user->id != auth()->user()->id)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <!-- Pesan -->
        <div class="form-group">
            <label for="message">Pesan</label>
            <textarea name="message" id="message" required placeholder="Tulis pesan di sini..."></textarea>
        </div>

        <!-- Tombol Kirim -->
        <button type="submit" class="btn-send">
            <i class="fas fa-paper-plane"></i> Kirim
        </button>
    </form>
</div>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- jQuery (load before Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#receiver_id').select2({
            placeholder: '-- Pilih Penerima --',
            allowClear: true
        });
    });
</script>
@endsection
