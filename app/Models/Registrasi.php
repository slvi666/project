<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'users'; // Specify the table associated with the model

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_name',
    ];

    // Specify the attributes that should be hidden for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Specify the attributes that should be cast to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Specify the dates for the model
    protected $dates = ['email_verified_at'];
}
