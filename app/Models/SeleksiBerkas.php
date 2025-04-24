<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeleksiBerkas extends Model
{
    use HasFactory;

    protected $table = 'seleksi_berkas';

    protected $fillable = [
        'user_id',
        'formulir_pendaftaran_id',
        'poto_ktp_orang_tua',
        'kartu_keluarga',
        'akte_kelahiran',
        'surat_kelulusan',
        'raport',
        'kis_kip',
        'ijazah'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke FormulirPendaftaran
    public function formulirPendaftaran()
    {
        return $this->belongsTo(FormulirPendaftaran::class);
    }
}
