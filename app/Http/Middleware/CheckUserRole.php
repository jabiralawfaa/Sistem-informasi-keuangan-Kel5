<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user memiliki role 'guest', kembalikan ke dashboard dengan pesan
        if ($user && $user->role === 'guest') {
            return redirect()->route('dashboard')->with('error', 'Your account is pending admin approval. Please wait for an admin to assign you a role.');
        }

        return $next($request);
    }
}
