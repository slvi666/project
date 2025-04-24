<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas_id', // Pastikan ada kelas_id untuk menyimpan ID kelas
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the kelas associated with the user.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }
    public function formulirPendaftaran()
    {
        return $this->hasOne(FormulirPendaftaran::class, 'user_id');
    }
    public function seleksiBerkas()
    {
        return $this->hasOne(SeleksiBerkas::class, 'user_id');
    }
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
    public function mataPelajaranDiampu()
    {
        return $this->hasMany(MataPelajaran::class, 'guru_id');
    }
    public function materiPembelajaran()
    {
        return $this->hasMany(MateriPembelajaran::class, 'guru_id');
    }
}
