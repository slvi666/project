<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // Menentukan kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'sender_id', 'receiver_id', 'message', 'sent_at',
    ];

    // Relasi dengan pengguna yang mengirim pesan
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relasi dengan pengguna yang menerima pesan
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
