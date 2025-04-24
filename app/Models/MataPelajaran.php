<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'subject_id',
        'guru_id',
        'siswa_ids',
        'waktu_mulai',
        'waktu_berakhir',
        'hari',
    ];

    protected $casts = [
        'siswa_ids' => 'array', // Supaya bisa langsung akses array siswa
    ];

    // Relasi ke Subject (mata pelajaran)
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Guru (user dengan role guru)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Relasi ke banyak siswa (via array)
    public function siswa()
    {
        return Siswa::whereIn('id', $this->siswa_ids)->get();
    }
}
