<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'sent_at'];

    // Relasi ke model User (Pengirim)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relasi ke model User (Penerima)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
