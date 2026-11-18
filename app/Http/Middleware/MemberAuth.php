<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('customer_id')) {
            return redirect('/login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        return $next($request);
    }
}