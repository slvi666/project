<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan memiliki role 'Admin'
        if (auth()->check() && auth()->user()->role_name === 'Admin') {
            return $next($request);
        }

        // Jika tidak, alihkan ke halaman yang sesuai, misalnya halaman home
        return redirect('/home');
    }
}
