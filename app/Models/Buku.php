<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku'; // Nama tabel

    protected $fillable = [
        'cover_buku',
        'judul',
        'penulis',
        'deskripsi',
        'kategori',
        'file_buku',
        'views',
    ];

    /**
     * Menentukan nilai default untuk beberapa atribut.
     */
    protected $attributes = [
        'views' => 0,
    ];

    /**
     * Konversi kategori ke format enum agar lebih mudah digunakan.
     */
    public static function getKategoriList()
    {
        return [
            'fiksi', 'non fiksi', 'keagamaan', 
            'edukasi dan akademik', 'pengembangan diri', 
            'bisnis dan ekonomi', 'seni dan hiburan'
        ];
    }
}
