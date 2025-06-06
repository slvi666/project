@extends('adminlte.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Halaman Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Total Kegiatan Card -->
        <div class="col-lg-6 mb-4">
          <div class="card shadow-lg rounded-4 border-0 bg-gradient-primary text-white hover-effect">
            <div class="card-body text-center py-5">
              <div class="icon-container mb-4">
              <i class="fas fa-handshake fa-4x animate__animated animate__pulse animate__infinite"></i>
              </div>
              <h3 class="display-4 font-weight-bold"></h3>
              <h3>Halo, selamat datang {{ auth()->user()->name }} ({{ auth()->user()->role_name }})</h3>
              <hr class="divider">
            </div>
          </div>
        </div>

<!-- Card Example -->
<div class="col-lg-6 mb-4">
  <div class="card card-outline card-primary h-100 hover-effect rounded-4 shadow-lg">
    <div class="card-body">
      <!-- Judul Pengumuman -->
      <h5 class="card-title font-weight-bold mb-3 text-center text-primary">Pengumuman Terbaru</h5>

      @php
        // Mengambil 3 pengumuman terbaru yang berstatus 'aktif'
        $pengumumanAktif = \App\Models\Pengumuman::where('status', 'aktif')->latest()->take(3)->get();
      @endphp

      @forelse($pengumumanAktif as $pengumuman)
        <!-- Judul Pengumuman -->
        <p class="display-6 text-primary text-center mb-2">
          {{ $pengumuman->judul_pengumuman }}
        </p>

        <!-- Deskripsi Pengumuman -->
        <p class="card-text mb-3">
          {{ $pengumuman->deskripsi_pengumuman }}
        </p>

        <!-- Tanggal Pengumuman -->
        <div class="d-flex justify-content-between text-muted mb-4">
          <p><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->format('d M Y') }}</p>
          <p><strong>Berakhir:</strong> {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->format('d M Y') }}</p>
        </div>

        <hr class="divider">
      @empty
        <p class="text-center text-muted">Tidak ada pengumuman aktif saat ini.</p>
      @endforelse

    </div>
  </div>
</div>


        
       {{-- JADWAL PELAJARAN --}}
          <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg rounded-4 hover-effect">
              <div class="card-header bg-gradient-primary text-white">
                <h5 class="m-0 font-weight-bold">Jadwal Pelajaran</h5>
              </div>
              <div class="card-body">

                  @php
                      $user = auth()->user();
      
                      // Initialize empty collection for jadwal data
                      $data = collect();
      
                      if ($user->role_name === 'siswa') {
                          // Ambil ID siswa dari relasi user
                          $siswaId = $user->siswa->id ?? null;
                          // Ambil mata pelajaran yang memiliki siswa_id sesuai user login
                          $data = \App\Models\MataPelajaran::with(['subject', 'guru'])
                              ->whereJsonContains('siswa_ids', (string) $siswaId)
                              ->get();
                      } elseif ($user->role_name === 'guru') {
                          // Guru bisa lihat data berdasarkan guru_id yang sama dengan user->id
                          $data = \App\Models\MataPelajaran::with(['subject', 'guru'])
                              ->where('guru_id', $user->id)
                              ->get();
                      } else {
                          // Role admin atau lainnya melihat semua data
                          $data = \App\Models\MataPelajaran::with(['subject', 'guru'])->get();
                      }
                  @endphp
      
                  @if($data->isEmpty())
                      <p class="card-text">Tidak ada jadwal pelajaran untuk Anda.</p>
                  @else
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                          <thead class="text-center table-primary">
                              <tr>
                                  <th scope="col">Mata Pelajaran</th>
                                  <th scope="col">Guru</th>
                                  <th scope="col">Hari</th>
                                  <th scope="col">Waktu Mulai</th>
                                  <th scope="col">Waktu Berakhir</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($data as $jadwal)
                                  <tr>
                                      <td>{{ $jadwal->subject->subject_name }}</td>
                                      <td>{{ $jadwal->guru->name }}</td>
                                      <td>{{ $jadwal->hari }}</td>
                                      <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</td>
                                      <td>{{ \Carbon\Carbon::parse($jadwal->waktu_berakhir)->format('H:i') }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                  @endif
    
              </div>
          </div>
      </div>
      
        
@php
    use App\Models\Exam;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $query = Exam::with('subject');

    if ($user->role_name === 'siswa') {
        $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
        $className = optional($siswa->subject)->class_name;

        $query->whereHas('subject', function ($q) use ($className) {
            $q->where('class_name', $className);
        });

    } elseif ($user->role_name === 'guru') {
        $query->where('guru_id', $user->id);
    }

    $exams = $query->latest()->take(5)->get();
@endphp

<!-- Jadwal Ujian - Tabel langsung pakai Model -->
<div class="col-lg-6 mb-4">
  <div class="card border-0 shadow-lg rounded-4 hover-effect">
    <div class="card-header bg-gradient-primary text-white">
      <h5 class="m-0 font-weight-bold">Jadwal Ujian</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
    <thead class="table-light">
      <tr>
        <th>Judul Ujian</th>
        <th>Mata Pelajaran</th>
        <th>Guru</th>
        <th>Durasi (menit)</th>
        <th>Waktu Mulai</th>
        <th>Waktu Selesai</th>
      </tr>
    </thead>
    <tbody>
      @foreach($exams as $exam)
        <tr>
          <td>{{ $exam->exam_title }}</td>
          <td>{{ $exam->subject->subject_name ?? '-' }}</td>
          <td>{{ $exam->guru->name ?? '-' }}</td>
          <td>{{ $exam->duration }}</td>
           <td>
                            {{ $exam->start_time 
                                ? \Carbon\Carbon::parse($exam->start_time)->translatedFormat('l, d F Y H:i') 
                                : '-' 
                            }}
                        </td>
                        <td>
                            {{ $exam->end_time 
                                ? \Carbon\Carbon::parse($exam->end_time)->translatedFormat('l, d F Y H:i') 
                                : '-' 
                            }}
                        </td>
        </tr>
      @endforeach
    </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@php
    use App\Models\TugasSiswa;
    $user = auth()->user();
    $openTugas = collect(); // default koleksi kosong

    if ($user->role_name === 'siswa' && $user->siswa) {
        $openTugas = TugasSiswa::where('siswa_id', $user->siswa->id)
                        ->whereNull('file_jawaban')
                        ->get();
    } elseif ($user->role_name !== 'siswa') {
        $openTugas = TugasSiswa::all();
    }
@endphp

@if($openTugas->isNotEmpty())
    <div class="col-lg-6 mb-4">
      <div class="card card-outline card-primary h-100 hover-effect rounded-4 shadow-lg">
        <div class="card-header">
          <h5 class="m-0 font-weight-bold">Total Data Tugas</h5>
        </div>
        <div class="card-body">
          <h6 class="card-title font-weight-bold">Jumlah Tugas Tersedia</h6>
          <p class="card-text">Jumlah total tugas yang belum Anda upload jawabannya.</p>
          <h3 class="display-4 text-primary">{{ $openTugas->count() }}</h3>
          <hr class="divider">
        </div>
      </div>
    </div>
@endif

      
      </div>
    </div>
  </div>
</div>

@endsection

@push('css')
<style>
  /* Efek Hover pada Kartu */
  .hover-effect:hover {
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(-8px);
    transition: all 0.3s ease-in-out;
  }

  /* Gradien Kartu */
  .bg-gradient-primary {
    background: linear-gradient(145deg, #6a11cb 0%, #2575fc 100%);
  }

  /* Animasi pada ikon */
  .icon-container i {
    color: white;
    transition: color 0.3s ease;
  }

  .icon-container:hover i {
    color: #ffcc00;
  }

  /* Styling angka */
  .display-4 {
    font-size: 3.5rem;
    font-weight: bold;
    transition: transform 0.3s ease-in-out;
  }

  .display-4:hover {
    transform: scale(1.1);
    color: #f8f9fa;
  }

  /* Menambah padding pada konten kartu */
  .card-body {
    padding: 2rem;
  }

  /* Header pada kartu */
  .card-header {
    background-color: #6a11cb;
    color: white;
  }

  /* Styling Sudut dan Bayangan pada Kartu */
  .card {
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  /* Divider Antara Bagian Teks */
  .divider {
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 20px;
    margin-bottom: 20px;
  }

  /* Animasi untuk ikon */
  .animate__pulse {
    animation: pulse 1s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }
</style>
@endpush
