<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakInformasi extends Model
{
    use HasFactory;

    protected $table = 'kontak_informasi';

    protected $fillable = [
        'nama_identitas',
        'email',
        'no_telpon',
        'alamat',
        'no_wa',
        'instagram',
        'fb',
    ];
}
