<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru'; // Nama tabel di database

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'alamat',
        'jenis_kelamin',
        'telepon',
        'tanggal_lahir',
        'tanggal_bergabung',
        'foto',
    ];

    /**
     * Relasi dengan model User
     * Satu guru berhubungan dengan satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tugas()
    {
        return $this->hasMany(TugasSiswa::class, 'guru_id');
    }
}
