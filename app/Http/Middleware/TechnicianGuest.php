<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechnicianGuest
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('technician_id')) {
            return redirect()->route('technician.dashboard');
        }

        return $next($request);
    }
}
