<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'formulir_pendaftaran';

    protected $fillable = [
        'foto',
        'nik',
        'user_id',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'agama',
        'no_hp',
        'alamat',
        'nama_orangtua',
        'asal_sekolah',
        'tahun_lulus',
        'status',
        'berkas_sertifikat', // Ditambahkan
        'nilai_us', // Ditambahkan
        'pekerjaan_orangtua',
        'penghasilan_orangtua',
        'jarak_rumah_sekolah',
        'kendaraan',
        'nama_bapak',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function seleksiBerkas()
    {
        return $this->hasOne(SeleksiBerkas::class, 'formulir_pendaftaran_id');
    }
}
