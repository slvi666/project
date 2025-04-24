<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mata_pelajaran_id',
        'siswa_id',
        'tanggal',
        'status',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}
