<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    // Nama tabel (optional kalau nama tabel sudah sesuai konvensi)
    protected $table = 'faqs';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'question',
        'answer',
    ];
}
