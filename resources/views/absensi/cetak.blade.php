<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Data Absensi</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    .header { margin-bottom: 10px; }
  </style>
</head>
<body>
  <div class="header">
    <h3>Data Absensi</h3>
    <p><strong>Mata Pelajaran:</strong> {{ $mataPelajaran->subject->subject_name ?? '-' }}</p>
    <p><strong>Guru:</strong> {{ $mataPelajaran->guru->name ?? '-' }}</p>
  </div>

  @forelse ($absensi as $tanggal => $items)
    <h4>Tanggal: {{ $tanggal }}</h4>
    <table>
      <thead>
        <tr>
          <th>Jam</th>
          <th>Nama Siswa</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
          <tr>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}</td>
            <td>{{ $item->siswa->user->name ?? '-' }}</td>
            <td>{{ ucfirst($item->status) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @empty
    <p>Tidak ada data absensi.</p>
  @endforelse
</body>
</html>
