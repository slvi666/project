<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul_pengumuman',
        'isi_pengumuman',
        'deskripsi_pengumuman',
        'status',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];
}
