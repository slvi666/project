<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokKegiatan extends Model
{
    use HasFactory;

    protected $table = 'dok_kegiatan'; // Nama tabel di database

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'path_file',
    ];
}
