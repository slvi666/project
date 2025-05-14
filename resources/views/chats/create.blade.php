@extends('adminlte.layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-container h1 {
        font-size: 1.8rem;
        margin-bottom: 25px;
        color: #2f3542;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2f3542;
    }

    select,
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 12px;
        font-size: 1rem;
        transition: border 0.3s;
        background: #f9f9f9;
    }

    select:focus,
    textarea:focus {
        border-color: #4cd137;
        outline: none;
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba(76, 209, 55, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .btn-send {
        display: inline-block;
        background-color: #4cd137;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 30px;
        font-weight: bold;
        font-size: 1rem;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .btn-send:hover {
        background-color: #44bd32;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        .btn-send {
            width: 100%;
        }
    }
</style>

<div class="form-container">
    <h1><i class="fas fa-paper-plane me-2 text-success"></i> Kirim Pesan</h1>

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
            <i class="fas fa-paper-plane me-1"></i> Kirim
        </button>
    </form>
</div>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- jQuery (di load dulu sebelum Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#receiver_id').select2({
            placeholder: '-- Pilih Penerima --', // Placeholder text
            allowClear: true  // Option to clear selection
        });
    });
</script>

@endsection
