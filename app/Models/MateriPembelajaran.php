<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    use HasFactory;

    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'guru_id',
        'subject_id',
        'file',
        'deskripsi',
    ];

    /**
     * Relasi ke model User (Guru)
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id')->where('role_name', 'guru');
    }

    /**
     * Relasi ke model Subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id', 'siswa_ids');
    }


    protected $casts = [
        'siswa_ids' => 'array',
    ];
}
